<?php

namespace App\Models\Data;

interface CurrencyHistoryInterface
{
    /**
     * @return CurrencyHistoryItemInterface[]
     */
    public function getItems(): array;
}
