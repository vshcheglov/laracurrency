<?php

namespace App\Services\CurrencyProvider;

use App\Services\CurrencyProvider\DataAggregator\DataAggregatorInterface;

class CurrencyProvider implements CurrencyProviderInterface
{
    public function __construct(private readonly DataAggregatorInterface $dataAggregator) {}

    public function getCurrencyInfo($currencyCode, ?\DateTime $fromDate = null, ?\DateTime $toDate = null): array
    {
        $data = $this->dataAggregator->prepareData($currencyCode);

        $filteredHistory = array_filter($data['history'], function ($item) use ($fromDate, $toDate) {
            $itemDate = \DateTime::createFromFormat('Y-m-d H:i:s', $item['date']);
            if ($fromDate !== null && $itemDate < $fromDate) {
                return false;
            }
            if ($toDate !== null && $itemDate > $toDate) {
                return false;
            }
            return true;
        });
        $data['history'] = array_values($filteredHistory);

        return $data;
    }
}
