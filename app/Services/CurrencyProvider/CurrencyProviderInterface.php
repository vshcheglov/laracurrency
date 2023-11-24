<?php

namespace App\Services\CurrencyProvider;

interface CurrencyProviderInterface
{
    public function getCurrencyInfo($currencyCode, ?\DateTime $fromDate = null, ?\DateTime $toDate = null): array;
}
