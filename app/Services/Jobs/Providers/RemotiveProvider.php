<?php

namespace App\Services\Jobs\Providers;

use App\Services\Jobs\Contracts\JobProviderInterface;
use App\Services\Jobs\Data\JobData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RemotiveProvider implements JobProviderInterface
{
    public function name(): string
    {
        return 'remotive';
    }

    public function fetchJobs(string $keyword, string $location): array
    {
        try {
            $response = Http::retry(2, 200)
                ->timeout(10)
                ->get('https://remotive.com/api/remote-jobs', ['search' => $keyword]);

            if ($response->failed()) {
                Log::warning('Remotive API failed', ['status' => $response->status()]);
                return [];
            }

            return collect($response->json('jobs', []))
                ->map(fn (array $item) => $this->toJobData($item))
                ->filter(fn (JobData $job) => $this->matchesLocation($job->locationText, $location))
                ->all();
        } catch (\Throwable $e) {
            Log::warning('Remotive job fetch failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function toJobData(array $item): JobData
    {
        $locationText = trim($item['candidate_required_location'] ?? $item['location'] ?? 'Remote');

        return new JobData(
            source: $this->name(),
            externalId: $this->extractId($item),
            title: trim($item['title'] ?? 'N/A'),
            company: trim($item['company_name'] ?? 'N/A'),
            locationText: $locationText,
            companyUrl: trim($item['company_website'] ?? $item['company_url'] ?? ''),
            url: trim($item['url'] ?? $item['job_url'] ?? $item['application_url'] ?? ''),
            description: trim($item['description'] ?? $item['summary'] ?? ''),
            datePosted: trim($item['publication_date'] ?? $item['created_at'] ?? ''),
            isRemote: $this->resolveRemote($item, $locationText),
            payload: $item,
        );
    }

    private function extractId(array $item): ?string
    {
        $id = $item['id'] ?? $item['job_id'] ?? $item['external_id'] ?? null;
        return $id ? trim((string) $id) : null;
    }

    private function resolveRemote(array $item, string $locationText): bool
    {
        if (! empty($item['is_remote'])) {
            $val = $item['is_remote'];
            if (is_bool($val)) return $val;
            if (in_array(strtolower(trim((string) $val)), ['1', 'true', 'yes', 'y', 'on'], true)) return true;
        }
        return str_contains(strtolower($locationText), 'remote');
    }

    private function matchesLocation(string $jobLocation, string $searchLocation): bool
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
}
