<?php

namespace App\Services\Jobs;

use App\Models\JobListing;
use App\Services\Jobs\Contracts\JobProviderInterface;
use App\Services\Jobs\Data\JobData;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Log;

class JobAggregator
{
    private const CACHE_TTL = 3600;

    private const MIN_RESULTS_FOR_CACHE = 16;

    /** @var JobProviderInterface[] */
    private array $providers = [];

    public function __construct(
        private readonly Cache $cache,
        JobProviderInterface ...$providers,
    ) {
        $this->providers = $providers;
    }

    public function fetchAndStore(string $keyword, string $location, bool $refresh = false): array
    {
        $keyword = trim($keyword);
        $location = trim($location);
        $cacheKey = $this->cacheKey($keyword, $location);

        if (! $refresh) {
            $cached = $this->cache->get($cacheKey);
            if ($cached !== null && count($cached) >= self::MIN_RESULTS_FOR_CACHE) {
                return $cached;
            }

            $stored = $this->fetchStored($keyword, $location);
            if ($stored->count() >= self::MIN_RESULTS_FOR_CACHE) {
                $result = $stored->map(fn (JobListing $job) => $this->format($job))->all();
                $this->cache->put($cacheKey, $result, self::CACHE_TTL);
                return $result;
            }
        }

        $jobs = $this->fetchFromProviders($keyword, $location);
        $this->storeJobs($jobs, $keyword, $location);

        $result = $this->fetchStored($keyword, $location)
            ->map(fn (JobListing $job) => $this->format($job))
            ->all();

        $this->cache->put($cacheKey, $result, self::CACHE_TTL);

        return $result;
    }

    /** @return JobData[] */
    private function fetchFromProviders(string $keyword, string $location): array
    {
        $all = collect();

        foreach ($this->providers as $provider) {
            try {
                $jobs = $provider->fetchJobs($keyword, $location);
                $all = $all->merge($jobs);
            } catch (\Throwable $e) {
                Log::error("{$provider->name()} provider crashed", ['error' => $e->getMessage()]);
            }
        }

        return $all
            ->unique(fn (JobData $job) => $job->fingerprint())
            ->values()
            ->all();
    }

    /** @param JobData[] $jobs */
    private function storeJobs(array $jobs, string $keyword, string $location): void
    {
        foreach ($jobs as $job) {
            $attributes = $job->externalId
                ? ['source' => $job->source, 'external_id' => $job->externalId]
                : ['source' => $job->source, 'url' => $job->url];

            JobListing::updateOrCreate($attributes, [
                'keyword' => $keyword,
                'location' => $location,
                'title' => $job->title,
                'company' => $job->company,
                'location_text' => $job->locationText,
                'company_url' => $job->companyUrl,
                'url' => $job->url,
                'description' => $job->description,
                'date_posted' => $job->datePosted,
                'is_remote' => $job->isRemote,
                'payload' => $job->payload,
            ]);
        }
    }

    private function fetchStored(string $keyword, string $location)
    {
        return JobListing::whereRaw('lower(keyword) = ?', [mb_strtolower($keyword)])
            ->whereRaw('lower(location) = ?', [mb_strtolower($location)])
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();
    }

    private function format(JobListing $job): array
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

    private function cacheKey(string $keyword, string $location): string
    {
        return 'jobs_' . sha1(mb_strtolower($keyword) . '|' . mb_strtolower($location));
    }
}
