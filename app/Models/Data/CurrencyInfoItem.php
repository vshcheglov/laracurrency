<?php

namespace App\Models\Data;

class CurrencyInfoItem implements CurrencyInfoItemInterface
{
    public function __construct(
        private readonly string    $currencyCode,
        private readonly string    $cbrCode,
        private readonly \DateTime $date,
        private readonly int       $nominal,
        private readonly float     $rate,
        private readonly float     $unitRate,
    ) {

    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getCbrCode(): string
    {
        return $this->cbrCode;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getNominal(): int
    {
        return $this->nominal;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getUnitRate(): float
    {
        return $this->unitRate;
    }
}
