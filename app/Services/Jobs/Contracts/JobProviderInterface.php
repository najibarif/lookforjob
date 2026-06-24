<?php

namespace App\Services\Jobs\Contracts;

use App\Services\Jobs\Data\JobData;

interface JobProviderInterface
{
    public function name(): string;

    /** @return JobData[] */
    public function fetchJobs(string $keyword, string $location): array;
}
