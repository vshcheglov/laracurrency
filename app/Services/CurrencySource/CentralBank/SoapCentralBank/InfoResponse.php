<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use App\Models\Data\CurrencyInfoInterface;
use App\Models\Data\CurrencyInfoItemInterface;
use Illuminate\Container\Container;
use Psr\Http\Message\ResponseInterface;

class InfoResponse implements InfoResponseInterface
{
    public function handle(ResponseInterface $response): CurrencyInfoInterface
    {
        /** @var CurrencyInfoInterface $currencyInfo */
        $currencyInfo = Container::getInstance()
            ->make(CurrencyInfoInterface::class, ['items' => $this->prepareItems($response)]);

        return $currencyInfo;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function prepareItems(ResponseInterface $response): array
    {
        try {
            $xml = simplexml_load_string($response->getBody()->getContents());
        } catch (\Throwable) {
            return [];
        }

        $historyItems = [];
        foreach ($this->parseXmlItems($xml) as $xmlItem) {
            try {
                $itemArgs = $this->prepareItemArgs($xml, $xmlItem);
                /** @var CurrencyInfoItemInterface $infoItem */
                $infoItem = Container::getInstance()
                    ->make(CurrencyInfoItemInterface::class, $itemArgs);
            } catch (\Throwable) {}
            $historyItems[] = $infoItem;
        }
        return $historyItems;
    }

    private function prepareItemArgs(\SimpleXMLElement $xml, \SimpleXMLElement $xmlItem): array
    {
        return [
            'currencyCode' => (string)$xmlItem->CharCode,
            'cbrCode' => (string)$xmlItem['ID'],
            'date' => $this->createDateTime((string)$xml['Date']),
            'nominal' => (int)$xmlItem->Nominal,
            'rate' => (float)str_replace(',', '.', $xmlItem->Value),
            'unitRate' => (float)str_replace(',', '.', $xmlItem->VunitRate)
        ];
    }

    /**
     * @param ResponseInterface $response
     * @return \SimpleXMLElement[]
     */
    private function parseXmlItems(\SimpleXMLElement $xml): array
    {
        try {
            $xml->registerXPathNamespace('soap', 'http://www.w3.org/2003/05/soap-envelope');
            return $xml->xpath('//Valute');
        } catch (\Throwable) {}
        return [];
    }

    private function createDateTime(string $date): \DateTime
    {
        return \DateTime::createFromFormat(
            'd.m.Y H:i:s',
            $date . ' 00:00:00'
        );
    }
}
