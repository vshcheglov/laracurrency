<?php

namespace App\Services\CurrencyProvider\DataAggregator;

use Illuminate\Support\Facades\Cache;

class CachedDataAggregator implements DataAggregatorInterface
{
    public function __construct(private readonly DataAggregatorInterface $dataAggregator) {}

    public function prepareData(string $currencyCode): array
    {
        $currencyStore = Cache::store('currency');

        $today = date('Y-m-d');
        $cacheKey = "cur_{$currencyCode}_{$today}";
        $cachedData = $currencyStore->get($cacheKey);

        if ($cachedData) {
            return json_decode($cachedData, true);
        }

        $data = $this->dataAggregator->prepareData($currencyCode);
        $currencyStore->set($cacheKey, json_encode($data), 86400);
        return $data;
    }
}
