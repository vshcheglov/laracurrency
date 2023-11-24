<?php

namespace App\Services\CurrencySource\CentralBank\SoapCentralBank;

use Psr\Http\Message\ResponseInterface;

interface InfoRequestInterface
{
    public function send(): ResponseInterface;
}
