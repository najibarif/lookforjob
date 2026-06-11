<?php

namespace App\Console\Commands;

use App\Services\JobAggregatorService;
use Illuminate\Console\Command;

class FetchJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:fetch {keyword?} {location?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch job listings from external APIs and save them to the database';

    /**
     * Execute the console command.
     */
    public function handle(JobAggregatorService $jobAggregatorService)
    {
        $keyword = $this->argument('keyword') ?? 'developer';
        $location = $this->argument('location') ?? '';

        $this->info("Fetching jobs for keyword: '{$keyword}' and location: '{$location}'...");

        // Set refresh to true to force fetching from API instead of retrieving from DB
        $jobs = $jobAggregatorService->fetchAndStore($keyword, $location, true);

        if (empty($jobs)) {
            $this->warn('No jobs found or failed to fetch jobs.');
            return 1; // FAILURE
        }

        $this->info('Successfully fetched and stored ' . count($jobs) . ' job(s) to the database.');

        // Optionally, display a table of the fetched jobs
        $this->table(
            ['Title', 'Company', 'Location', 'Source'],
            collect($jobs)->map(fn ($job) => [
                $job['title'],
                $job['company'],
                $job['location_text'],
                $job['source'],
            ])->toArray()
        );

        return 0; // SUCCESS
    }
}
