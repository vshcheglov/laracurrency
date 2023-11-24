<?php

namespace App\Services\CurrencySource\CentralBank;

use App\Models\Data\CurrencyHistoryInterface;
use App\Models\Data\CurrencyInfoInterface;

interface CentralBankInterface
{
    public function getCurrencyHistory(string $cbrCode): CurrencyHistoryInterface;

    public function getCurrencyInfo(): CurrencyInfoInterface;
}
