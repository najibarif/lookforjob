<?php

namespace App\Providers;

use App\Services\Jobs\Contracts\JobProviderInterface;
use App\Services\Jobs\JobAggregator;
use App\Services\Jobs\Providers\ArbeitNowProvider;
use App\Services\Jobs\Providers\LinkedInProvider;
use App\Services\Jobs\Providers\RemotiveProvider;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            LinkedInProvider::class,
            RemotiveProvider::class,
            ArbeitNowProvider::class,
        ], 'job-providers');

        $this->app->bind(JobAggregator::class, function ($app) {
            $providers = $app->tagged('job-providers');
            $cache = $app->make(Cache::class);
            return new JobAggregator($cache, ...$providers);
        });
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}