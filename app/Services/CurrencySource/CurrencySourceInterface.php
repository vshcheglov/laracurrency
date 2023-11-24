<?php

namespace App\Services\CurrencySource;

use App\Models\Data\CurrencyHistoryInterface;
use App\Models\Data\CurrencyInfoInterface;

interface CurrencySourceInterface
{
    public function getCurrencyHistory(string $currencyCode): CurrencyHistoryInterface;

    public function getCurrencyInfo(): CurrencyInfoInterface;
}
