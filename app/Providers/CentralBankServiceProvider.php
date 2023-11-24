<?php

namespace App\Providers;

use App\Services\CurrencySource\CentralBank\CentralBankInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\HistoryRequest;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\HistoryRequestInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\HistoryResponse;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\HistoryResponseInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\InfoRequest;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\InfoRequestInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\InfoResponse;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\InfoResponseInterface;
use Illuminate\Support\ServiceProvider;

class CentralBankServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            HistoryRequestInterface::class,
            HistoryRequest::class
        );

        $this->app->bind(
            HistoryResponseInterface::class,
            HistoryResponse::class
        );

        $this->app->bind(
            InfoRequestInterface::class,
            InfoRequest::class
        );

        $this->app->bind(
            InfoResponseInterface::class,
            InfoResponse::class
        );

        $this->app->bind(
            CentralBankInterface::class,
            SoapCentralBank::class
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
