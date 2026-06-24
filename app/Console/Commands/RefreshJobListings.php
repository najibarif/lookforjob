<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use App\Services\Jobs\JobAggregator;
use Illuminate\Console\Command;

class RefreshJobListings extends Command
{
    protected $signature = 'jobs:refresh {--limit=20 : Number of recent saved keyword/location pairs to refresh}';

    protected $description = 'Refresh saved job listings by re-querying the configured job APIs.';

    public function handle(JobAggregator $aggregator): int
    {
        $limit = (int) $this->option('limit');
        $pairs = JobListing::select('keyword', 'location')
            ->distinct()
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get();

        if ($pairs->isEmpty()) {
            $this->info('Tidak ada pasangan kata kunci/lokasi yang tersimpan untuk diperbarui.');
            return self::SUCCESS;
        }

        $this->info('Memperbarui cache pencarian pekerjaan untuk ' . $pairs->count() . ' kombinasi.');

        foreach ($pairs as $pair) {
            $this->info("Refreshing: {$pair->keyword} | {$pair->location}");
            $aggregator->fetchAndStore($pair->keyword, $pair->location, true);
        }

        $this->info('Selesai memperbarui data pekerjaan.');

        return self::SUCCESS;
    }
}
