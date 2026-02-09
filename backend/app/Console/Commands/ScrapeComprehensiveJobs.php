<?php

namespace App\Console\Commands;

use App\Models\ScrapedJob;
use App\Services\JobScraperService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScrapeComprehensiveJobs extends Command
{
    protected $signature = 'scrape:comprehensive 
        {--limit=100 : Maximum jobs to scrape per source}
        {--source=* : Specific sources to scrape (leave empty for all)}
        {--dry-run : Show what would be scraped without saving}';

    protected $description = 'Comprehensive job scraper from multiple Indonesian and international sources';

    private JobScraperService $scraper;
    private int $totalScraped = 0;
    private int $totalSaved = 0;
    private int $totalDuplicates = 0;
    private array $stats = [];

    public function __construct(JobScraperService $scraper)
    {
        parent::__construct();
        $this->scraper = $scraper;
    }

    public function handle()
    {
        $this->info('🚀 Starting Comprehensive Job Scraper');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        $sources = $this->option('source') ?: [
            'glints',
            'kalibrr',
            'techinasia',
            'jobstreet',
            'urbanhire',
            'linkedin',
            'lever',
        ];

        $limit = (int) $this->option('limit');
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No data will be saved');
        }

        foreach ($sources as $source) {
            $this->newLine();
            $this->info("📡 Scraping: " . strtoupper($source));
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

            $method = 'scrape' . ucfirst(strtolower($source));

            if (method_exists($this, $method)) {
                try {
                    $this->$method($limit, $isDryRun);
                } catch (\Exception $e) {
                    $this->error("❌ Failed to scrape {$source}: " . $e->getMessage());
                    Log::error("Scraper error [{$source}]: " . $e->getMessage());
                }
            } else {
                $this->warn("⚠️  Scraper for '{$source}' not implemented yet");
            }
        }

        $this->showStatistics();
    }

    /**
     * Scrape Glints (Tech jobs)
     */
    private function scrapeGlints(int $limit, bool $isDryRun): void
    {
        // Glints uses an API endpoint
        $url = 'https://glints.com/api/job-posts?country=ID&limit=' . $limit;

        $data = $this->scraper->httpGetJson($url);

        if (!$data || !isset($data['data'])) {
            $this->warn('⚠️  No data from Glints API');
            return;
        }

        $jobs = $data['data'];
        $this->stats['glints']['fetched'] = count($jobs);

        foreach ($jobs as $job) {
            $jobData = [
                'position' => $job['title'] ?? 'Unknown',
                'company' => $job['company']['name'] ?? 'Unknown',
                'location' => $job['CityInfo']['name'] ?? 'Indonesia',
                'description' => $job['description'] ?? null,
                'requirements' => $job['requirements'] ?? null,
                'jobUrl' => "https://glints.com/opportunities/jobs/{$job['id']}",
                'date' => $job['createdAt'] ?? now(),
                'salary' => $this->extractGlintsSalary($job),
                'companyLogo' => $job['company']['logo'] ?? null,
                'keyword' => $job['category'] ?? 'Tech',
                'category' => 'Technology',
                'employment_type' => $job['type'] ?? 'Full-time',
                'is_remote' => $job['isRemote'] ?? false,
                'source' => 'glints',
            ];

            $this->saveJob($jobData, $isDryRun);
        }
    }

    private function extractGlintsSalary(array $job): string
    {
        if (isset($job['salaryEstimate'])) {
            $min = $job['salaryEstimate']['minAmount'] ?? null;
            $max = $job['salaryEstimate']['maxAmount'] ?? null;
            $currency = $job['salaryEstimate']['currency'] ?? 'IDR';

            if ($min && $max) {
                return "{$currency} " . number_format($min) . " - " . number_format($max);
            }
        }

        return 'Not disclosed';
    }

    /**
     * Scrape Kalibrr
     */
    private function scrapeKalibrr(int $limit, bool $isDryRun): void
    {
        // Kalibrr API endpoint
        $url = "https://www.kalibrr.com/api/job_board/jobs?country=Indonesia&limit={$limit}";

        $data = $this->scraper->httpGetJson($url);

        if (!$data || !isset($data['jobs'])) {
            $this->warn('⚠️  No data from Kalibrr API');
            return;
        }

        $jobs = $data['jobs'];
        $this->stats['kalibrr']['fetched'] = count($jobs);

        foreach ($jobs as $job) {
            $jobData = [
                'position' => $job['name'] ?? 'Unknown',
                'company' => $job['company_name'] ?? 'Unknown',
                'location' => $job['location']['name'] ?? 'Indonesia',
                'description' => $job['description'] ?? null,
                'requirements' => $job['requirements'] ?? null,
                'jobUrl' => "https://www.kalibrr.com/c/{$job['company_id']}/jobs/{$job['id']}",
                'date' => $job['created_at'] ?? now(),
                'salary' => 'Not disclosed',
                'companyLogo' => $job['company_logo'] ?? null,
                'keyword' => $job['primary_role'] ?? 'General',
                'source' => 'kalibrr',
            ];

            $this->saveJob($jobData, $isDryRun);
        }
    }

    /**
     * Scrape TechInAsia (Keep existing implementation)
     */
    private function scrapeTechinasia(int $limit, bool $isDryRun): void
    {
        $url = "https://www.techinasia.com/api/2.0/job-postings?country_name[]=Indonesia&limit={$limit}";

        $response = Http::timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ])
            ->get($url);

        if (!$response->successful()) {
            $this->warn('⚠️  TechInAsia API failed');
            return;
        }

        $data = $response->json();
        $jobs = $data['data'] ?? [];
        $this->stats['techinasia']['fetched'] = count($jobs);

        foreach ($jobs as $job) {
            $slug = $job['slug'] ?? $job['id'];

            $jobData = [
                'position' => $job['title'],
                'company' => $job['company']['name'] ?? 'Unknown Company',
                'location' => 'Indonesia',
                'description' => $job['description'] ?? null,
                'jobUrl' => "https://www.techinasia.com/jobs/{$slug}",
                'date' => $job['updated_at'] ?? $job['created_at'] ?? now(),
                'keyword' => $job['category']['name'] ?? 'Tech',
                'category' => 'Technology',
                'source' => 'techinasia',
                'salary' => ($job['salary_min'] > 0)
                    ? ($job['salary_currency'] ?? 'IDR') . " {$job['salary_min']} - {$job['salary_max']}"
                    : 'Not disclosed',
                'companyLogo' => $job['company']['avatar_url'] ?? null
            ];

            $this->saveJob($jobData, $isDryRun);
        }
    }

    /**
     * Scrape JobStreet Indonesia
     */
    private function scrapeJobstreet(int $limit, bool $isDryRun): void
    {
        // JobStreet has Schema.org markup
        $url = 'https://www.jobstreet.co.id/jobs';

        $html = $this->scraper->httpGet($url);

        if (!$html) {
            $this->warn('⚠️  Failed to fetch JobStreet');
            return;
        }

        $jobs = $this->scraper->extractSchemaOrgJobs($html);
        $this->stats['jobstreet']['fetched'] = count($jobs);

        $count = 0;
        foreach ($jobs as $jobData) {
            if ($count >= $limit)
                break;

            $jobData['source'] = 'jobstreet';
            $this->saveJob($jobData, $isDryRun);
            $count++;
        }
    }

    /**
     * Scrape Urbanhire
     */
    private function scrapeUrbanhire(int $limit, bool $isDryRun): void
    {
        $url = 'https://www.urbanhire.com/jobs';

        $html = $this->scraper->httpGet($url);

        if (!$html) {
            $this->warn('⚠️  Failed to fetch Urbanhire');
            return;
        }

        $jobs = $this->scraper->extractSchemaOrgJobs($html);
        $this->stats['urbanhire']['fetched'] = count($jobs);

        $count = 0;
        foreach ($jobs as $jobData) {
            if ($count >= $limit)
                break;

            $jobData['source'] = 'urbanhire';
            $this->saveJob($jobData, $isDryRun);
            $count++;
        }
    }

    /**
     * Scrape LinkedIn Jobs (Public)
     */
    private function scrapeLinkedin(int $limit, bool $isDryRun): void
    {
        // LinkedIn public job search
        $url = "https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?location=Indonesia&start=0&count={$limit}";

        $html = $this->scraper->httpGet($url);

        if (!$html) {
            $this->warn('⚠️  Failed to fetch LinkedIn');
            return;
        }

        // Parse HTML for job listings
        preg_match_all(
            '/<div class="base-card relative w-full hover:no-underline.*?<h3 class="base-search-card__title">(.*?)<\/h3>.*?<h4 class="base-search-card__subtitle">(.*?)<\/h4>.*?<span class="job-search-card__location">(.*?)<\/span>.*?<a.*?href="(.*?)".*?>/s',
            $html,
            $matches,
            PREG_SET_ORDER
        );

        $this->stats['linkedin']['fetched'] = count($matches);

        foreach ($matches as $match) {
            if (!isset($match[1], $match[2], $match[3], $match[4]))
                continue;

            $jobData = [
                'position' => trim(strip_tags($match[1])),
                'company' => trim(strip_tags($match[2])),
                'location' => trim(strip_tags($match[3])),
                'jobUrl' => htmlspecialchars_decode($match[4]),
                'date' => now(),
                'source' => 'linkedin',
            ];

            $this->saveJob($jobData, $isDryRun);
        }
    }

    /**
     * Scrape Lever-powered careers pages
     */
    private function scrapeLever(int $limit, bool $isDryRun): void
    {
        // Example Lever API endpoints (many startups use Lever)
        $companies = [
            'gojek' => 'https://api.lever.co/v0/postings/gojek?mode=json',
            'tokopedia' => 'https://api.lever.co/v0/postings/tokopedia?mode=json',
            'bukalapak' => 'https://api.lever.co/v0/postings/bukalapak?mode=json',
        ];

        $totalFetched = 0;

        foreach ($companies as $company => $url) {
            $data = $this->scraper->httpGetJson($url);

            if (!$data || !is_array($data)) {
                continue;
            }

            $totalFetched += count($data);

            foreach ($data as $job) {
                if (!isset($job['text'], $job['hostedUrl']))
                    continue;

                $location = 'Indonesia';
                if (isset($job['categories']['location'])) {
                    $location = $job['categories']['location'];
                }

                $jobData = [
                    'position' => $job['text'],
                    'company' => ucfirst($company),
                    'location' => $location,
                    'description' => $job['description'] ?? null,
                    'requirements' => $job['lists'][0]['content'] ?? null,
                    'jobUrl' => $job['hostedUrl'],
                    'date' => isset($job['createdAt']) ? Carbon::createFromTimestampMs($job['createdAt']) : now(),
                    'category' => $job['categories']['team'] ?? 'General',
                    'source' => 'lever',
                ];

                $this->saveJob($jobData, $isDryRun);
            }
        }

        $this->stats['lever']['fetched'] = $totalFetched;
    }

    /**
     * Save job to database
     */
    private function saveJob(array $jobData, bool $isDryRun): void
    {
        $this->totalScraped++;

        // Normalize data
        $normalized = $this->scraper->normalizeJobData($jobData);

        if ($isDryRun) {
            $this->line("  [DRY RUN] {$normalized['position']} @ {$normalized['company']}");
            return;
        }

        // Check for duplicates
        $existing = ScrapedJob::where('jobUrl', $normalized['jobUrl'])->first();

        if ($existing) {
            $this->totalDuplicates++;
            return;
        }

        try {
            // Add agoTime
            $normalized['agoTime'] = Carbon::parse($normalized['date'])->diffForHumans();

            ScrapedJob::create($normalized);

            $this->totalSaved++;
            $this->line("  ✅ {$normalized['position']} @ {$normalized['company']}");

        } catch (\Exception $e) {
            $this->error("  ❌ Failed to save: " . $e->getMessage());
            Log::error("Failed to save job: " . $e->getMessage(), $normalized);
        }
    }

    /**
     * Show scraping statistics
     */
    private function showStatistics(): void
    {
        $this->newLine(2);
        $this->info('📊 Scraping Statistics');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Scraped', $this->totalScraped],
                ['Successfully Saved', $this->totalSaved],
                ['Duplicates Skipped', $this->totalDuplicates],
                ['Total in Database', ScrapedJob::count()],
            ]
        );

        if (!empty($this->stats)) {
            $this->newLine();
            $this->info('📈 Per-Source Statistics');
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

            $rows = [];
            foreach ($this->stats as $source => $data) {
                $rows[] = [
                    ucfirst($source),
                    $data['fetched'] ?? 0,
                ];
            }

            $this->table(['Source', 'Jobs Fetched'], $rows);
        }

        $this->newLine();
        $this->info('✅ Scraping completed successfully!');
    }
}
