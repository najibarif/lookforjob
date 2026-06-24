<?php

namespace App\Services\Jobs\Providers;

use App\Services\Jobs\Contracts\JobProviderInterface;
use App\Services\Jobs\Data\JobData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInProvider implements JobProviderInterface
{
    public function name(): string
    {
        return 'linkedin';
    }

    public function fetchJobs(string $keyword, string $location): array
    {
        try {
            $response = Http::retry(2, 200)
                ->timeout(10)
                ->withHeaders([
                    'X-RapidAPI-Key' => config('services.linkedin.key'),
                    'X-RapidAPI-Host' => config('services.linkedin.host'),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://jobs-search-api.p.rapidapi.com/getjobs', [
                    'search_term' => $keyword,
                    'location' => $location,
                ]);

            if ($response->failed()) {
                Log::warning('LinkedIn API failed', ['status' => $response->status()]);
                return [];
            }

            return collect($response->json('data.jobs') ?? $response->json('jobs') ?? [])
                ->map(fn (array $item) => $this->toJobData($item))
                ->filter(fn (JobData $job) => $job->url !== '' && $job->title !== 'N/A')
                ->all();
        } catch (\Throwable $e) {
            Log::warning('LinkedIn job fetch failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function toJobData(array $item): JobData
    {
        return new JobData(
            source: $this->name(),
            externalId: $this->extractId($item),
            title: trim($item['title'] ?? 'N/A'),
            company: trim($item['company'] ?? 'N/A'),
            locationText: trim($item['location'] ?? 'Remote'),
            companyUrl: trim($item['company_url'] ?? $item['company_website'] ?? ''),
            url: trim($item['url'] ?? $item['job_url'] ?? $item['application_url'] ?? ''),
            description: trim($item['description'] ?? $item['summary'] ?? $item['snippet'] ?? ''),
            datePosted: trim($item['date_posted'] ?? $item['publication_date'] ?? $item['created_at'] ?? ''),
            isRemote: $this->resolveRemote($item),
            payload: $item,
        );
    }

    private function extractId(array $item): ?string
    {
        $id = $item['id'] ?? $item['job_id'] ?? $item['external_id'] ?? $item['reference'] ?? null;
        return $id ? trim((string) $id) : null;
    }

    private function resolveRemote(array $item): bool
    {
        if (! empty($item['is_remote'])) {
            $val = $item['is_remote'];
            if (is_bool($val)) return $val;
            if (in_array(strtolower(trim((string) $val)), ['1', 'true', 'yes', 'y', 'on'], true)) return true;
        }
        return str_contains(strtolower($item['location'] ?? ''), 'remote');
    }
}
