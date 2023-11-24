<?php

namespace App\Models\Data;

interface CurrencyInfoInterface
{
    /**
     * @return CurrencyInfoItemInterface[]
     */
    public function getItems();
}
