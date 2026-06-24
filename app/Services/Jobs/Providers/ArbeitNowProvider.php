<?php

namespace App\Services\Jobs\Providers;

use App\Services\Jobs\Contracts\JobProviderInterface;
use App\Services\Jobs\Data\JobData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ArbeitNowProvider implements JobProviderInterface
{
    public function name(): string
    {
        return 'arbeitnow';
    }

    public function fetchJobs(string $keyword, string $location): array
    {
        try {
            $response = Http::retry(2, 200)
                ->timeout(10)
                ->get('https://www.arbeitnow.com/api/job-board-api', ['search' => $keyword]);

            if ($response->failed()) {
                Log::warning('ArbeitNow API failed', ['status' => $response->status()]);
                return [];
            }

            return collect($response->json('data', []))
                ->filter(fn (array $item) => $this->matchesLocation($item, $keyword, $location))
                ->map(fn (array $item) => $this->toJobData($item))
                ->filter(fn (JobData $job) => $job->url !== '' && $job->title !== 'N/A')
                ->values()
                ->all();
        } catch (\Throwable $e) {
            Log::warning('ArbeitNow job fetch failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    private function toJobData(array $item): JobData
    {
        $locationText = trim($item['location'] ?? 'Remote');

        return new JobData(
            source: $this->name(),
            externalId: $this->extractId($item),
            title: trim($item['title'] ?? $item['job_title'] ?? $item['position'] ?? 'N/A'),
            company: trim($item['company_name'] ?? $item['company'] ?? 'N/A'),
            locationText: $locationText,
            companyUrl: trim($item['company_url'] ?? $item['company_website'] ?? ''),
            url: trim($item['url'] ?? $item['job_url'] ?? $item['application_url'] ?? ''),
            description: trim($item['description'] ?? $item['summary'] ?? ''),
            datePosted: trim($item['created_at'] ?? $item['publication_date'] ?? ''),
            isRemote: $this->resolveRemote($item, $locationText),
            payload: $item,
        );
    }

    private function extractId(array $item): ?string
    {
        $id = $item['id'] ?? $item['job_id'] ?? $item['slug'] ?? null;
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

    private function matchesLocation(array $item, string $keyword, string $location): bool
    {
        $kw = trim(strtolower($keyword));
        $loc = trim(strtolower($location));

        if ($kw !== '') {
            $haystack = strtolower(implode(' ', [
                $item['title'] ?? '',
                $item['company_name'] ?? $item['company'] ?? '',
                $item['description'] ?? '',
                $item['location'] ?? '',
            ]));
            if (! Str::contains($haystack, $kw)) {
                return false;
            }
        }

        if ($loc === '') {
            return true;
        }

        $jobLocation = trim(strtolower($item['location'] ?? ''));
        return Str::contains($jobLocation, $loc)
            || Str::contains($jobLocation, 'remote')
            || Str::contains($loc, 'remote');
    }
}
