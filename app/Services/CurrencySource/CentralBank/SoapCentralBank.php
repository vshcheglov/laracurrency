<?php

namespace App\Services\CurrencySource\CentralBank;

use App\Models\Data\CurrencyHistoryInterface;
use App\Models\Data\CurrencyInfoInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\HistoryRequestInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\HistoryResponseInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\InfoRequestInterface;
use App\Services\CurrencySource\CentralBank\SoapCentralBank\InfoResponseInterface;

class SoapCentralBank implements CentralBankInterface
{
    public function __construct(
        private readonly HistoryRequestInterface $historyRequest,
        private readonly HistoryResponseInterface $historyResponse,
        private readonly InfoRequestInterface $infoRequest,
        private readonly InfoResponseInterface $infoResponse
    ) {

    }

    public function getCurrencyHistory(string $cbrCode): CurrencyHistoryInterface
    {
        $fromDate = now()->subMonths(3)->toIso8601String();
        $toDate = now()->subDay(1)->toIso8601String();
        $response = $this->historyRequest->send($fromDate, $toDate, $cbrCode);
        return $this->historyResponse->handle($response);
    }

    public function getCurrencyInfo(): CurrencyInfoInterface
    {
        $response = $this->infoRequest->send();
        return $this->infoResponse->handle($response);
    }
}
