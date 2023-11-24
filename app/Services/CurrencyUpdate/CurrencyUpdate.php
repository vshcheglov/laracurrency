<?php

namespace App\Services\CurrencyUpdate;

use App\Models\Currency;
use App\Models\CurrencyHistoryItem;
use App\Services\CurrencySource\CurrencySourceInterface;

class CurrencyUpdate implements CurrencyUpdateInterface
{
    public function __construct(private readonly CurrencySourceInterface $currencySource)
    {

    }

    public function execute()
    {
        $this->updateCurrencies();
        foreach (Currency::all() as $currency) {
            $this->updateHistory($currency);
        }
    }

    private function updateCurrencies()
    {
        $insertData = [];
        $currencyInfo = $this->currencySource->getCurrencyInfo();
        foreach ($currencyInfo->getItems() as $item) {
            $insertData[] = [
                'currency_code' => $item->getCurrencyCode(),
                'cbr_code' => $item->getCbrCode(),
                'date' => $item->getDate(),
                'nominal' => $item->getNominal(),
                'rate' => $item->getRate(),
                'unit_rate' => $item->getUnitRate()
            ];
        }
        Currency::upsert(
            $insertData,
            ['currency_code', 'cbr_code'],
            [
                'date',
                'nominal',
                'rate',
                'unit_rate'
            ]
        );
    }

    private function updateHistory(Currency $currency)
    {
        $insertData = [];
        $currencyHistory = $this->currencySource->getCurrencyHistory($currency->getAttribute('currency_code'));
        foreach ($currencyHistory->getItems() as $item) {
            $insertData[] = [
                'currency_id' => $currency->getAttribute('id'),
                'date' => $item->getDate(),
                'nominal' => $item->getNominal(),
                'rate' => $item->getRate(),
                'unit_rate' =>$item->getUnitRate()
            ];
        }
        CurrencyHistoryItem::upsert(
            $insertData,
            ['currency_id', 'date'],
            ['nominal', 'rate', 'unit_rate']
        );
    }
}
