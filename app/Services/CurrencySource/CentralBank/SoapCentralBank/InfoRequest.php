<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class InfoRequest implements InfoRequestInterface
{
    public function send(): ResponseInterface
    {
        try {
            $client = new Client();
            return $client->request('GET', 'https://www.cbr.ru/scripts/XML_daily.asp', [
                'timeout' => 30,
                'connect_timeout' => 30,
            ]);
        } catch (\Throwable $e) {
            Log::error($e);
            return new InfoNullResponse();
        }
    }
}
