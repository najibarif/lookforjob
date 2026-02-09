<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class JobScraperService
{
    private array $userAgents = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    ];

    private int $retryAttempts = 3;
    private int $retryDelay = 2000; // milliseconds
    private int $requestDelay = 1000; // milliseconds between requests

    /**
     * Make HTTP GET request with retry logic
     */
    public function httpGet(string $url, array $headers = [], int $timeout = 30): ?string
    {
        $attempt = 0;

        while ($attempt < $this->retryAttempts) {
            try {
                $response = Http::timeout($timeout)
                    ->withHeaders(array_merge([
                        'User-Agent' => $this->getRandomUserAgent(),
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        'Accept-Language' => 'en-US,en;q=0.9',
                    ], $headers))
                    ->get($url);

                if ($response->successful()) {
                    // Respectful delay
                    usleep($this->requestDelay * 1000);
                    return $response->body();
                }

                $attempt++;
                if ($attempt < $this->retryAttempts) {
                    usleep($this->retryDelay * 1000);
                }

            } catch (Exception $e) {
                Log::warning("HTTP request failed (attempt {$attempt}): " . $e->getMessage());
                $attempt++;
                if ($attempt < $this->retryAttempts) {
                    usleep($this->retryDelay * 1000);
                }
            }
        }

        return null;
    }

    /**
     * Make HTTP GET request and parse JSON
     */
    public function httpGetJson(string $url, array $headers = [], int $timeout = 30): ?array
    {
        $attempt = 0;

        while ($attempt < $this->retryAttempts) {
            try {
                $response = Http::timeout($timeout)
                    ->withHeaders(array_merge([
                        'User-Agent' => $this->getRandomUserAgent(),
                        'Accept' => 'application/json',
                    ], $headers))
                    ->get($url);

                if ($response->successful()) {
                    usleep($this->requestDelay * 1000);
                    return $response->json();
                }

                $attempt++;
                if ($attempt < $this->retryAttempts) {
                    usleep($this->retryDelay * 1000);
                }

            } catch (Exception $e) {
                Log::warning("JSON request failed (attempt {$attempt}): " . $e->getMessage());
                $attempt++;
                if ($attempt < $this->retryAttempts) {
                    usleep($this->retryDelay * 1000);
                }
            }
        }

        return null;
    }

    /**
     * Extract Schema.org JobPosting from HTML
     */
    public function extractSchemaOrgJobs(string $html): array
    {
        $jobs = [];

        preg_match_all(
            '/<script type="application\/ld\+json">(.*?)<\/script>/s',
            $html,
            $matches
        );

        foreach ($matches[1] ?? [] as $json) {
            $data = json_decode($json, true);
            if (!$data)
                continue;

            // Handle @graph structure
            if (isset($data['@graph'])) {
                foreach ($data['@graph'] as $node) {
                    if ($this->isJobPosting($node)) {
                        $jobs[] = $this->parseSchemaOrgJob($node);
                    }
                }
            } elseif ($this->isJobPosting($data)) {
                $jobs[] = $this->parseSchemaOrgJob($data);
            }
        }

        return array_filter($jobs);
    }

    /**
     * Check if data is a JobPosting
     */
    private function isJobPosting(array $data): bool
    {
        $type = $data['@type'] ?? '';
        return $type === 'JobPosting' || (is_array($type) && in_array('JobPosting', $type));
    }

    /**
     * Parse Schema.org JobPosting
     */
    private function parseSchemaOrgJob(array $job): ?array
    {
        try {
            $location = $this->extractLocation($job['jobLocation'] ?? []);

            return [
                'position' => $job['title'] ?? null,
                'company' => $job['hiringOrganization']['name'] ?? null,
                'location' => $location,
                'description' => $job['description'] ?? null,
                'requirements' => $job['qualifications'] ?? $job['skills'] ?? null,
                'jobUrl' => $job['url'] ?? null,
                'date' => $job['datePosted'] ?? null,
                'employment_type' => $job['employmentType'] ?? null,
                'category' => $job['industry'] ?? null,
                'is_remote' => $this->isRemoteJob($job),
                'salary' => $this->extractSalary($job['baseSalary'] ?? null),
                'source' => 'schema.org',
            ];
        } catch (Exception $e) {
            Log::warning("Failed to parse Schema.org job: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Extract location from jobLocation
     */
    private function extractLocation($jobLocation): string
    {
        if (is_string($jobLocation)) {
            return $jobLocation;
        }

        if (is_array($jobLocation)) {
            $address = $jobLocation['address'] ?? [];

            if (is_string($address)) {
                return $address;
            }

            if (is_array($address)) {
                return implode(', ', array_filter([
                    $address['addressLocality'] ?? null,
                    $address['addressRegion'] ?? null,
                    $address['addressCountry'] ?? null,
                ]));
            }
        }

        return 'Indonesia';
    }

    /**
     * Check if job is remote
     */
    private function isRemoteJob(array $job): bool
    {
        $applicantLocation = $job['applicantLocationRequirements'] ?? [];
        $jobLocation = $job['jobLocation'] ?? [];

        // Check for remote indicators
        if (
            isset($job['jobLocationType']) &&
            in_array($job['jobLocationType'], ['TELECOMMUTE', 'REMOTE'])
        ) {
            return true;
        }

        // Check location text
        $locationText = strtolower(json_encode([$applicantLocation, $jobLocation]));
        return str_contains($locationText, 'remote') ||
            str_contains($locationText, 'work from home');
    }

    /**
     * Extract salary from baseSalary
     */
    private function extractSalary($baseSalary): string
    {
        if (!$baseSalary) {
            return 'Not disclosed';
        }

        if (is_string($baseSalary)) {
            return $baseSalary;
        }

        if (is_array($baseSalary)) {
            $currency = $baseSalary['currency'] ?? 'IDR';
            $value = $baseSalary['value'] ?? null;
            $minValue = $baseSalary['minValue'] ?? null;
            $maxValue = $baseSalary['maxValue'] ?? null;

            if ($minValue && $maxValue) {
                return "{$currency} {$minValue} - {$maxValue}";
            }

            if ($value) {
                return "{$currency} {$value}";
            }
        }

        return 'Not disclosed';
    }

    /**
     * Normalize job data
     */
    public function normalizeJobData(array $job): array
    {
        return [
            'position' => $this->cleanText($job['position'] ?? 'Unknown'),
            'company' => $this->cleanText($job['company'] ?? 'Unknown'),
            'location' => $this->normalizeLocation($job['location'] ?? 'Indonesia'),
            'description' => $this->cleanText($job['description'] ?? null),
            'requirements' => $this->cleanText($job['requirements'] ?? null),
            'jobUrl' => $job['jobUrl'] ?? null,
            'date' => $job['date'] ?? now(),
            'salary' => $job['salary'] ?? 'Not disclosed',
            'companyLogo' => $job['companyLogo'] ?? null,
            'keyword' => $job['keyword'] ?? $job['category'] ?? 'General',
            'category' => $this->categorizeJob($job),
            'employment_type' => $this->normalizeEmploymentType($job['employment_type'] ?? null),
            'experience_level' => $this->detectExperienceLevel($job),
            'is_remote' => $job['is_remote'] ?? false,
            'source' => $job['source'] ?? 'unknown',
        ];
    }

    /**
     * Clean text
     */
    private function cleanText(?string $text): ?string
    {
        if (!$text)
            return null;

        // Remove HTML tags
        $text = strip_tags($text);

        // Normalize whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    /**
     * Normalize location
     */
    private function normalizeLocation(string $location): string
    {
        $location = trim($location);

        // Common location mappings
        $mappings = [
            'DKI Jakarta' => 'Jakarta',
            'Jakarta Raya' => 'Jakarta',
            'Jabodetabek' => 'Jakarta',
            'ID' => 'Indonesia',
        ];

        return $mappings[$location] ?? $location;
    }

    /**
     * Categorize job based on title and description
     */
    private function categorizeJob(array $job): string
    {
        $text = strtolower(($job['position'] ?? '') . ' ' . ($job['description'] ?? ''));

        $categories = [
            'Technology' => ['developer', 'engineer', 'programmer', 'software', 'tech', 'data', 'it ', 'devops', 'backend', 'frontend'],
            'Marketing' => ['marketing', 'seo', 'content', 'social media', 'digital marketing', 'brand'],
            'Sales' => ['sales', 'business development', 'account manager', 'relationship manager'],
            'Design' => ['designer', 'ui', 'ux', 'graphic', 'creative'],
            'Finance' => ['finance', 'accounting', 'accountant', 'financial', 'treasurer'],
            'HR' => ['hr', 'human resource', 'recruiter', 'talent acquisition', 'people'],
            'Operations' => ['operations', 'operation manager', 'logistics', 'supply chain'],
            'Customer Service' => ['customer service', 'customer support', 'cs ', 'support'],
            'Product' => ['product manager', 'product owner', 'product'],
        ];

        foreach ($categories as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    return $category;
                }
            }
        }

        return 'General';
    }

    /**
     * Normalize employment type
     */
    private function normalizeEmploymentType(?string $type): string
    {
        if (!$type)
            return 'Full-time';

        $type = strtolower($type);

        if (str_contains($type, 'full') || str_contains($type, 'permanent')) {
            return 'Full-time';
        } elseif (str_contains($type, 'part')) {
            return 'Part-time';
        } elseif (str_contains($type, 'contract') || str_contains($type, 'freelance')) {
            return 'Contract';
        } elseif (str_contains($type, 'intern')) {
            return 'Internship';
        }

        return 'Full-time';
    }

    /**
     * Detect experience level
     */
    private function detectExperienceLevel(array $job): string
    {
        $text = strtolower(($job['position'] ?? '') . ' ' . ($job['requirements'] ?? ''));

        if (str_contains($text, 'senior') || str_contains($text, 'lead') || str_contains($text, 'principal')) {
            return 'Senior';
        } elseif (str_contains($text, 'junior') || str_contains($text, 'entry') || str_contains($text, 'graduate')) {
            return 'Entry Level';
        } elseif (str_contains($text, 'intern')) {
            return 'Internship';
        }

        return 'Mid Level';
    }

    /**
     * Get random user agent
     */
    private function getRandomUserAgent(): string
    {
        return $this->userAgents[array_rand($this->userAgents)];
    }

    /**
     * Generate unique job hash for deduplication
     */
    public function generateJobHash(array $job): string
    {
        $uniqueString = ($job['position'] ?? '') . '|' .
            ($job['company'] ?? '') . '|' .
            ($job['location'] ?? '');

        return md5(strtolower($uniqueString));
    }
}
