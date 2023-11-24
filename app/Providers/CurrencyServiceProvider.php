<?php

namespace App\Providers;

use App\Models\Data\CurrencyHistory;
use App\Models\Data\CurrencyHistoryInterface;
use App\Models\Data\CurrencyHistoryItem;
use App\Models\Data\CurrencyHistoryItemInterface;
use App\Models\Data\CurrencyInfo;
use App\Models\Data\CurrencyInfoInterface;
use App\Models\Data\CurrencyInfoItem;
use App\Models\Data\CurrencyInfoItemInterface;
use App\Services\CurrencyProvider\CurrencyProviderInterface;
use App\Services\CurrencyProvider\CurrencyProvider;
use App\Services\CurrencyProvider\DataAggregator\CachedDataAggregator;
use App\Services\CurrencyProvider\DataAggregator\DataAggregatorInterface;
use App\Services\CurrencyProvider\DataAggregator\DbDataAggregator;
use App\Services\CurrencyService;
use App\Services\CurrencyService\CacheHistoryLoader;
use App\Services\CurrencyService\HistoryLoaderInterface;
use App\Services\CurrencyService\SoapHistoryLoader;
use App\Services\CurrencySource\CentralBankSource;
use App\Services\CurrencySource\CurrencySourceInterface;
use App\Services\CurrencyUpdate\CurrencyUpdate;
use App\Services\CurrencyUpdate\CurrencyUpdateInterface;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CurrencySourceInterface::class,
            CentralBankSource::class
        );

        $this->app->bind(
            CurrencyUpdateInterface::class,
            CurrencyUpdate::class
        );

        $this->app->bind(
            CurrencyProviderInterface::class,
            CurrencyProvider::class
        );

        $this->app->bind(
            CurrencyHistoryInterface::class,
            CurrencyHistory::class
        );

        $this->app->bind(
            CurrencyHistoryItemInterface::class,
            CurrencyHistoryItem::class
        );

        $this->app->bind(
            CurrencyInfoInterface::class,
            CurrencyInfo::class
        );

        $this->app->bind(
            CurrencyInfoItemInterface::class,
            CurrencyInfoItem::class
        );

        $this->app->when(CachedDataAggregator::class)
            ->needs(DataAggregatorInterface::class)
            ->give(DbDataAggregator::class);

        $this->app->when(CurrencyProvider::class)
            ->needs(DataAggregatorInterface::class)
            ->give(CachedDataAggregator::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
