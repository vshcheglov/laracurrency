<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use App\Models\Data\CurrencyHistoryInterface;
use Psr\Http\Message\ResponseInterface;

interface HistoryResponseInterface
{
    public function handle(ResponseInterface $response): CurrencyHistoryInterface;
}
