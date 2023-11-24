<?php

namespace App\Services\CurrencyProvider\DataAggregator;

interface DataAggregatorInterface
{
    public function prepareData(string $currencyCode): array;
}
