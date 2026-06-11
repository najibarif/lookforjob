<?php

namespace App\Services;

use App\Services\JobAggregatorService;

class JobScraper
{
    public function __construct(protected JobAggregatorService $aggregator)
    {
    }

    public function scrapeIndeed(string $keyword, string $location, bool $refresh = false): array
    {
        return $this->aggregator->fetchAndStore($keyword, $location, $refresh);
    }
}
