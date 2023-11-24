<?php

namespace App\Providers;

use App\Cache\Fpc\BasicCacheKeyGenerator;
use App\Cache\Fpc\CacheKeyGeneratorInterface;
use App\Services\CurrencyService;
use App\Services\CurrencyService\CacheHistoryLoader;
use App\Services\CurrencyService\HistoryLoaderInterface;
use App\Services\CurrencyService\SoapHistoryLoader;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\ServiceProvider;
use Psr\SimpleCache\CacheInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
