<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

class HistoryRequest implements HistoryRequestInterface
{
    public function send(string $fromDate, string $toDate, string $cbrCode): ResponseInterface
    {
        try {
            $client = new Client();
            return $client->request('POST', 'https://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx', [
                'headers' => [
                    'Content-Type' => 'application/soap+xml; charset=utf-8',
                ],
                'body' => $this->prepareBody($fromDate, $toDate, $cbrCode),
                'timeout' => 30,
                'connect_timeout' => 30,
            ]);
        } catch (\Throwable $e) {
            Log::error($e);
            return new HistoryNullResponse();
        }
    }

    private function prepareBody(string $fromDate, string $toDate, string $cbrCode): string
    {
        $envelope = new SimpleXMLElement('<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"></soap12:Envelope>');
        $body = $envelope->addChild('soap12:Body', '', 'http://www.w3.org/2003/05/soap-envelope');
        $getCursDynamicXML = $body->addChild('GetCursDynamicXML', '', 'http://web.cbr.ru/');
        $getCursDynamicXML->addChild('FromDate', $fromDate);
        $getCursDynamicXML->addChild('ToDate', $toDate);
        $getCursDynamicXML->addChild('ValutaCode', $cbrCode);
        return $envelope->asXML();
    }
}
