<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use App\Models\Data\CurrencyInfoInterface;
use Psr\Http\Message\ResponseInterface;

interface InfoResponseInterface
{
    public function handle(ResponseInterface $response): CurrencyInfoInterface;
}
