<?php

namespace App\Models\Data;

class CurrencyHistoryItem implements CurrencyHistoryItemInterface
{
    public function __construct(
        private readonly \DateTime $date,
        private readonly int $nominal,
        private readonly float $rate,
        private readonly float $unitRate
    ) {

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
