<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use App\Models\Data\CurrencyHistoryInterface;
use App\Models\Data\CurrencyHistoryItemInterface;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class HistoryResponse implements HistoryResponseInterface
{
    public function handle(ResponseInterface $response): CurrencyHistoryInterface
    {
        /** @var CurrencyHistoryInterface $currencyHistory */
        $currencyHistory = Container::getInstance()
            ->make(CurrencyHistoryInterface::class, ['items' => $this->prepareItems($response)]);

        return $currencyHistory;
    }

    /**
     * @return CurrencyHistoryItemInterface[]
     */
    private function prepareItems(ResponseInterface $response): array
    {
        $historyItems = [];
        $lastItem = null;
        foreach ($this->parseXmlItems($response) as $xmlItem) {
            try {
                $historyItemArgs = $this->prepareItemArgs($xmlItem);
                /** @var CurrencyHistoryItemInterface $currentItem */
                $currentItem = Container::getInstance()
                    ->make(CurrencyHistoryItemInterface::class, $historyItemArgs);
                if ($this->needToAddMissedDays($lastItem, $currentItem)) {
                    $this->addHistoryItemsForMissedDays($historyItems, $lastItem, $currentItem);
                }
                $historyItems[] = $currentItem;
                $lastItem = $currentItem;
            } catch (\Throwable $e) {
                Log::error($e);
            }
        }
        return $historyItems;
    }

    private function prepareItemArgs(\SimpleXMLElement $xmlItem): array
    {
        return [
            'date' => $this->createDateTime((string)$xmlItem->CursDate),
            'nominal' => (int)$xmlItem->Vnom,
            'rate' => (float)str_replace(',', '.', $xmlItem->Vcurs),
            'unitRate' => (float)str_replace(',', '.', $xmlItem->VunitRate),
        ];
    }

    /**
     * @param ResponseInterface $response
     * @return \SimpleXMLElement[]
     */
    private function parseXmlItems(ResponseInterface $response): array
    {
        try {
            $xml = simplexml_load_string($response->getBody()->getContents());
            $xml->registerXPathNamespace('soap', 'http://www.w3.org/2003/05/soap-envelope');
            return $xml->xpath('//ValuteCursDynamic');
        } catch (\Throwable $e) {
            Log::error($e);
        }
        return [];
    }

    private function createDateTime(string $date): \DateTime
    {
        $dateTime = \DateTime::createFromFormat(\DateTime::ATOM, $date);
        return $dateTime;
    }

    private function needToAddMissedDays(?CurrencyHistoryItemInterface $lastItem, CurrencyHistoryItemInterface $currentItem): bool
    {
        return $lastItem && $currentItem->getDate()->diff($lastItem->getDate())->days > 1;
    }

    private function addHistoryItemsForMissedDays(&$historyItems, CurrencyHistoryItemInterface $lastItem, CurrencyHistoryItemInterface $currentItem)
    {
        $missedDates = $this->getMissedDates($lastItem->getDate(), $currentItem->getDate());
        foreach ($missedDates as $missingDate) {
            $historyItems[] = $this->createMissingHistoryItem($missingDate, $lastItem);
        }
    }

    private function getMissedDates(\DateTime $startDate, \DateTime $endDate): array
    {
        $missingDates = [];
        $start = clone $startDate;
        $period = new \DatePeriod(
            $start->modify('+1 day'),
            new \DateInterval('P1D'),
            $endDate
        );

        foreach ($period as $date) {
            $missingDates[] = $date;
        }

        return $missingDates;
    }

    private function createMissingHistoryItem(\DateTime $date, CurrencyHistoryItemInterface $lastHistoryItem): CurrencyHistoryItemInterface
    {
        $newHistoryItem = Container::getInstance()
            ->make(CurrencyHistoryItemInterface::class, [
                'date' => $date,
                'nominal' => $lastHistoryItem->getNominal(),
                'rate' => $lastHistoryItem->getRate(),
                'unitRate' => $lastHistoryItem->getUnitRate()
            ]);
        return $newHistoryItem;
    }
}
