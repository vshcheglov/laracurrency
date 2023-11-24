<?php

namespace App\Services\CurrencyProvider\DataAggregator;

use App\Models\Currency;
use App\Models\CurrencyHistoryItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DbDataAggregator implements DataAggregatorInterface
{
    public function prepareData(string $currencyCode): array
    {
        $currency = Currency::where('currency_code', $currencyCode)->first();
        if (!$currency) {
            return [];
        }

        $historyItems = [];
        foreach ($this->loadHistory($currency) as $item) {
            $data = $item->toArray();
            $historyItems[] = $data;
        }

        return [
            'info' => $currency->toArray(),
            'history' => $historyItems
        ];
    }

    /**
     * @return Collection
     */
    private function loadHistory(Currency $currency): Collection
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        $today = Carbon::now()->startOfDay();

        return CurrencyHistoryItem::join('currency', function ($join) {
            $join->on('currency_history.currency_id', '=', 'currency.id')
                ->on('currency_history.nominal', '=', 'currency.nominal');
        })
            ->select('currency_history.*')
            ->where('currency_history.currency_id', '=', $currency->getKey())
            ->where('currency_history.date', '>', $threeMonthsAgo)
            ->whereDate('currency_history.date', '<', $today)
            ->orderBy('currency_history.date', 'desc')
            ->get();
    }
}
