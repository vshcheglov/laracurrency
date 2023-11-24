<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use App\Models\Data\CurrencyHistoryInterface;
use App\Models\Data\CurrencyHistoryItemInterface;
use Illuminate\Container\Container;
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
        foreach ($this->parseXmlItems($response) as $xmlItem) {
            try {
                $historyItemArgs = $this->prepareItemArgs($xmlItem);
                /** @var CurrencyHistoryItemInterface $historyItem */
                $historyItem = Container::getInstance()
                    ->make(CurrencyHistoryItemInterface::class, $historyItemArgs);
                $historyItems[] = $historyItem;
            } catch (\Throwable) {}
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
        } catch (\Throwable) {}
        return [];
    }

    private function createDateTime(string $date): \DateTime
    {
        $dateTime = \DateTime::createFromFormat(\DateTime::ATOM, $date);
        return $dateTime;
    }
}
