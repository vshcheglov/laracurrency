<?php

namespace App\Models\Data;

class CurrencyInfo implements CurrencyInfoInterface
{
    public function __construct(private readonly array $items = [])
    {
    }

    public function getItems()
    {
        return $this->items;
    }
}
