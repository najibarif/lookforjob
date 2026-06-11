<?php

namespace App\Services;

use App\Models\JobListing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JobAggregatorService
{
    public function __construct(protected LinkedInService $linkedInService)
    {
    }

    public function fetchAndStore(string $keyword, string $location, bool $refresh = false): array
    {
        $keyword = trim($keyword);
        $location = trim($location);

        $storedJobs = $this->findStoredJobs($keyword, $location);
        if ($storedJobs->isNotEmpty() && ! $refresh && $storedJobs->count() >= 16) {
            return $storedJobs->map(fn (JobListing $job) => $this->formatStoredJob($job))->all();
        }

        $aggregatedJobs = collect()
            ->merge($this->fetchLinkedInJobs($keyword, $location))
            ->merge($this->fetchRemotiveJobs($keyword, $location))
            ->merge($this->fetchArbeitNowJobs($keyword, $location))
            ->unique(fn (array $job) => $job['fingerprint'])
            ->values();

        $savedJobs = [];
        foreach ($aggregatedJobs as $job) {
            $this->storeJob($job, $keyword, $location);
        }

        return JobListing::whereRaw('lower(keyword) LIKE ?', ['%' . mb_strtolower($keyword) . '%'])
            ->whereRaw('lower(location) LIKE ?', ['%' . mb_strtolower($location) . '%'])
            ->orderByDesc('created_at')
            ->limit(100)
            ->get()
            ->map(fn (JobListing $job) => $this->formatStoredJob($job))
            ->all();
    }

    protected function findStoredJobs(string $keyword, string $location)
    {
        return JobListing::whereRaw('lower(keyword) = ?', [mb_strtolower($keyword)])
            ->whereRaw('lower(location) = ?', [mb_strtolower($location)])
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();
    }

    protected function fetchLinkedInJobs(string $keyword, string $location): array
    {
        try {
            $response = $this->linkedInService->getJobs($keyword, $location);
            $items = $response['data']['jobs'] ?? $response['jobs'] ?? [];

            return collect($items)
                ->map(fn ($item) => $this->normalizeJob($item, 'linkedin'))
                ->filter(fn ($job) => ! empty($job['url']) && ! empty($job['title']))
                ->all();
        } catch (\Throwable $e) {
            Log::warning('LinkedIn job fetch failed:', ['error' => $e->getMessage()]);
            return [];
        }
    }

    protected function fetchRemotiveJobs(string $keyword, string $location): array
    {
        try {
            $response = Http::timeout(10)
                ->get('https://remotive.com/api/remote-jobs', ['search' => $keyword]);

            if (! $response->successful()) {
                return [];
            }

            return collect($response->json('jobs', []))
                ->map(fn ($item) => $this->normalizeJob($item, 'remotive'))
                ->filter(fn ($job) => $this->matchesLocation($job['location_text'], $location))
                ->all();
        } catch (\Throwable $e) {
            Log::warning('Remotive job fetch failed:', ['error' => $e->getMessage()]);
            return [];
        }
    }

    protected function fetchArbeitNowJobs(string $keyword, string $location): array
    {
        try {
            $response = Http::timeout(10)
                ->get('https://www.arbeitnow.com/api/job-board-api');

            if (! $response->successful()) {
                return [];
            }

            return collect($response->json('data', []))
                ->filter(fn ($item) => $this->matchesKeyword($item, $keyword))
                ->filter(fn ($item) => $this->matchesLocation($item['location'] ?? '', $location))
                ->map(fn ($item) => $this->normalizeJob($item, 'arbeitnow'))
                ->filter(fn ($job) => ! empty($job['url']) && ! empty($job['title']))
                ->all();
        } catch (\Throwable $e) {
            Log::warning('ArbeitNow job fetch failed:', ['error' => $e->getMessage()]);
            return [];
        }
    }

    protected function normalizeJob(array $job, string $source): array
    {
        $title = trim($job['title'] ?? $job['job_title'] ?? $job['position'] ?? 'N/A');
        $company = trim($job['company'] ?? $job['company_name'] ?? $job['company_name'] ?? 'N/A');
        $locationText = trim($job['location'] ?? $job['candidate_required_location'] ?? $job['location_text'] ?? 'Remote');
        $url = trim($job['url'] ?? $job['job_url'] ?? $job['application_url'] ?? '');
        $companyUrl = trim($job['company_url'] ?? $job['company_website'] ?? '');
        $description = trim($job['description'] ?? $job['summary'] ?? $job['snippet'] ?? '');
        $datePosted = trim($job['date_posted'] ?? $job['publication_date'] ?? $job['created_at'] ?? '');
        $isRemote = $this->toBoolean($job['is_remote'] ?? false) || Str::contains(Str::lower($locationText), 'remote');

        $externalId = $this->extractExternalId($job, $source, $url, $title, $company, $locationText);
        $fingerprint = sha1($source . '|' . ($externalId ?: $url) . '|' . $title . '|' . $company . '|' . $url);

        return [
            'source' => $source,
            'external_id' => $externalId,
            'title' => $title,
            'company' => $company,
            'location_text' => $locationText,
            'company_url' => $companyUrl,
            'url' => $url,
            'description' => $description,
            'date_posted' => $datePosted,
            'is_remote' => $isRemote,
            'payload' => $job,
            'fingerprint' => $fingerprint,
        ];
    }

    protected function matchesLocation(string $jobLocation, string $searchLocation): bool
    {
        $searchLocation = trim(strtolower($searchLocation));
        $jobLocation = trim(strtolower($jobLocation));

        if ($searchLocation === '') {
            return true;
        }

        return Str::contains($jobLocation, $searchLocation)
            || Str::contains($jobLocation, 'remote')
            || Str::contains($searchLocation, 'remote');
    }

    protected function matchesKeyword(array $job, string $keyword): bool
    {
        $keyword = trim(strtolower($keyword));
        if ($keyword === '') {
            return true;
        }

        $haystack = strtolower(implode(' ', [
            $job['title'] ?? '',
            $job['company_name'] ?? $job['company'] ?? '',
            $job['description'] ?? '',
            $job['location'] ?? '',
        ]));

        return Str::contains($haystack, $keyword);
    }

    protected function extractExternalId(array $job, string $source, string $url, string $title, string $company, string $locationText): ?string
    {
        return trim((string) ($job['id'] ?? $job['job_id'] ?? $job['external_id'] ?? $job['reference'] ?? '')) ?: sha1($source . '|' . $url . '|' . $title . '|' . $company . '|' . $locationText);
    }

    protected function toBoolean(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $value = trim(strtolower((string) $value));

        return in_array($value, ['1', 'true', 'yes', 'y', 'on'], true);
    }

    protected function storeJob(array $job, string $keyword, string $location): array
    {
        $attributes = [
            'source' => $job['source'],
            'external_id' => $job['external_id'],
        ];

        if (empty($job['external_id']) && ! empty($job['url'])) {
            $attributes = [
                'source' => $job['source'],
                'url' => $job['url'],
            ];
        }

        $stored = JobListing::updateOrCreate($attributes, [
            'keyword' => $keyword,
            'location' => $location,
            'title' => $job['title'],
            'company' => $job['company'],
            'location_text' => $job['location_text'],
            'company_url' => $job['company_url'],
            'url' => $job['url'],
            'description' => $job['description'],
            'date_posted' => $job['date_posted'],
            'is_remote' => $job['is_remote'],
            'payload' => $job['payload'],
        ]);

        return $this->formatStoredJob($stored);
    }

    protected function formatStoredJob(JobListing $job): array
    {
        return [
            'id' => $job->id,
            'source' => $job->source,
            'external_id' => $job->external_id,
            'keyword' => $job->keyword,
            'location' => $job->location,
            'title' => $job->title,
            'company' => $job->company,
            'location_text' => $job->location_text,
            'company_url' => $job->company_url,
            'url' => $job->url,
            'description' => $job->description,
            'date_posted' => $job->date_posted,
            'is_remote' => $job->is_remote,
            'payload' => $job->payload,
            'created_at' => $job->created_at?->toDateTimeString(),
            'updated_at' => $job->updated_at?->toDateTimeString(),
        ];
    }
}
