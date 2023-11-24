<?php

namespace App\Providers;

use App\Cache\Fpc\BasicCacheKeyGenerator;
use App\Cache\Fpc\CacheKeyGeneratorInterface;
use Illuminate\Support\ServiceProvider;

class FpcServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CacheKeyGeneratorInterface::class,
            BasicCacheKeyGenerator::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
