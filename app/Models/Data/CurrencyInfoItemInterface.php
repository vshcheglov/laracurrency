<?php

namespace App\Models\Data;

interface CurrencyInfoItemInterface
{
    public function getCurrencyCode(): string;

    public function getCbrCode(): string;

    public function getDate(): \DateTime;

    public function getNominal(): int;

    public function getRate(): float;

    public function getUnitRate(): float;
}
