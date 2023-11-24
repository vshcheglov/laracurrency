<?php

namespace App\Models\Data;

interface CurrencyHistoryItemInterface
{
    public function getDate(): \DateTime;

    public function getNominal(): int;

    public function getRate(): float;

    public function getUnitRate(): float;
}
