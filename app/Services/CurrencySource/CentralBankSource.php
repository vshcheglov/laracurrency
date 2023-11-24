<?php

namespace App\Services\CurrencySource;

use App\Models\Currency;
use App\Models\Data\CurrencyHistoryInterface;
use App\Models\Data\CurrencyInfoInterface;
use App\Services\CurrencySource\CentralBank\CentralBankInterface;
use Illuminate\Container\Container;

class CentralBankSource implements CurrencySourceInterface
{
    public function __construct(private readonly CentralBankInterface $centralBank)
    {
    }

    public function getCurrencyHistory(string $currencyCode): CurrencyHistoryInterface
    {
        $currency = Currency::where('currency_code', $currencyCode)->first();
        if ($currency) {
            return $this->centralBank->getCurrencyHistory($currency->getAttribute('cbr_code'));
        }
        return Container::getInstance()
            ->make(CurrencyHistoryInterface::class, ['items' => []]);
    }

    public function getCurrencyInfo(): CurrencyInfoInterface
    {
        return $this->centralBank->getCurrencyInfo();
    }
}
