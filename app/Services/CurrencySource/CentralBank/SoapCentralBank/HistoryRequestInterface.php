<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use Psr\Http\Message\ResponseInterface;

interface HistoryRequestInterface
{
    public function send(string $fromDate, string $toDate, string $cbrCode): ResponseInterface;
}
