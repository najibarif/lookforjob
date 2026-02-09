<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ScrapedJob;
use Carbon\Carbon;

class ScrapeJobsIndonesia extends Command
{
    protected $signature = 'scrape:indonesia 
        {--company=* : Company career URLs (optional)}';

    protected $description = 'Hybrid job scraper for Indonesia (JSON API + Schema.org fallback)';

    public function handle()
    {
        $this->info('🚀 Starting Indonesia Hybrid Job Scraper');

        $targets = $this->option('company') ?: [
            // 'https://careers.gotocompany.com',
            // 'https://careers.shopee.co.id',
            // 'https://careers.blibli.com',
            // 'https://www.traveloka.com/en-id/careers',
            // 'https://www.tiket.com/careers',
            // 'https://career.astra.co.id',
            // 'https://www.unilever.co.id/careers',
        ];

        foreach ($targets as $url) {
            $this->info("🔍 Processing: {$url}");

            // 1️⃣ Try JSON APIs
            if ($this->tryKnownApis($url)) {
                $this->info("✅ JSON API success");
                continue;
            }

            // 2️⃣ Fallback schema
            $this->scrapeSchema($url);
        }

        // 3️⃣ TechInAsia API (Reliable Source)
        $this->scrapeTechInAsia();

        $this->info('🎉 Indonesia job scraping completed');
    }

    /**
     * Try known Indonesian JSON APIs
     */
    private function tryKnownApis(string $url): bool
    {
        $map = [
            'gotocompany.com' => 'https://careers.gotocompany.com/api/jobs',
            'shopee.co.id' => 'https://careers.shopee.co.id/api/job-list',
            'blibli.com' => 'https://careers.blibli.com/api/jobs',
            'traveloka.com' => 'https://api.traveloka.com/careers/jobs',
            'tiket.com' => 'https://www.tiket.com/careers/api/jobs',
        ];

        foreach ($map as $key => $api) {
            if (!str_contains($url, $key))
                continue;

            try {
                $res = Http::timeout(30)->get($api);
                if (!$res->successful())
                    return false;

                $data = $res->json();
                if (!is_array($data))
                    return false;

                foreach ($data as $job) {
                    $this->saveJob([
                        'position' => $job['title'] ?? $job['jobTitle'] ?? 'Unknown',
                        'company' => $job['company'] ?? ucfirst($key),
                        'location' => $job['location'] ?? 'Indonesia',
                        'jobUrl' => $job['apply_url'] ?? $job['url'] ?? $url,
                        'date' => $job['posted_at'] ?? now(),
                        'keyword' => $job['department'] ?? 'General',
                        'source' => 'internal-api',
                    ]);
                }

                return true;

            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Fallback Schema.org JobPosting
     */
    private function scrapeSchema(string $url): void
    {
        try {
            $html = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)',
                ])
                ->get($url)
                ->body();

            preg_match_all(
                '/<script type="application\/ld\+json">(.*?)<\/script>/s',
                $html,
                $matches
            );

            foreach ($matches[1] ?? [] as $json) {
                $data = json_decode($json, true);
                if (!$data)
                    continue;

                if (isset($data['@graph'])) {
                    foreach ($data['@graph'] as $node) {
                        $this->saveSchemaJob($node, $url);
                    }
                } else {
                    $this->saveSchemaJob($data, $url);
                }
            }

        } catch (\Exception $e) {
            $this->warn('⚠️ Schema fallback failed');
        }
    }

    private function saveSchemaJob(array $job, string $url): void
    {
        if (($job['@type'] ?? '') !== 'JobPosting')
            return;

        $this->saveJob([
            'position' => $job['title'] ?? 'Unknown',
            'company' => $job['hiringOrganization']['name'] ?? 'Unknown',
            'location' => $job['jobLocation']['address']['addressLocality'] ?? 'Indonesia',
            'jobUrl' => $job['url'] ?? $url,
            'date' => $job['datePosted'] ?? now(),
            'keyword' => $job['employmentType'] ?? 'General',
            'source' => 'schema.org',
        ]);
    }

    /**
     * Centralized save
     */
    private function saveJob(array $job): void
    {
        ScrapedJob::updateOrCreate(
            ['jobUrl' => $job['jobUrl']],
            [
                'position' => $job['position'],
                'company' => $job['company'],
                'location' => $job['location'],
                'salary' => $job['salary'] ?? 'Not disclosed',
                'companyLogo' => $job['companyLogo'] ?? null,
                'date' => Carbon::parse($job['date']),
                'agoTime' => Carbon::parse($job['date'])->diffForHumans(),
                'keyword' => $job['keyword'],
                'source' => $job['source'],
            ]
        );

        $this->info("✅ Saved: {$job['position']} ({$job['company']})");
    }
    private function scrapeTechInAsia(): void
    {
        $this->info("🔍 Crawling: TechInAsia Jobs (Indonesia)");
        $url = 'https://www.techinasia.com/api/2.0/job-postings?country_name[]=Indonesia&limit=20';

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                ])
                ->get($url);

            if (!$response->successful()) {
                $this->warn('⚠️ TechInAsia API failed');
                return;
            }

            $data = $response->json();
            $jobs = $data['data'] ?? [];

            foreach ($jobs as $job) {
                // Construct URL (slug is usually present, or ID)
                $slug = $job['slug'] ?? $job['id'];
                $jobUrl = "https://www.techinasia.com/jobs/{$slug}";

                $Companyname = $job['company']['name'] ?? 'Unknown Company';
                $Companylogo = $job['company']['avatar_url'] ?? null;

                $this->saveJob([
                    'position' => $job['title'],
                    'company' => $Companyname,
                    'location' => 'Indonesia', // API filtered by Indonesia
                    'jobUrl' => $jobUrl,
                    'date' => $job['updated_at'] ?? $job['created_at'] ?? now(),
                    'keyword' => $job['category']['name'] ?? 'Tech', // Adjust based on actual JSON
                    'source' => 'techinasia',
                    'salary' => ($job['salary_min'] > 0) ? ($job['salary_currency'] ?? 'IDR') . " {$job['salary_min']} - {$job['salary_max']}" : 'Not disclosed',
                    'companyLogo' => $Companylogo
                ]);
            }

        } catch (\Exception $e) {
            $this->warn("⚠️ TechInAsia error: {$e->getMessage()}");
        }
    }
}
