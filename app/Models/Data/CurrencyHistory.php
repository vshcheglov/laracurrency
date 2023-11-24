<?php

namespace App\Models\Data;

class CurrencyHistory implements CurrencyHistoryInterface
{
    public function __construct(
        private readonly array $items = []
    ) {}

    public function getItems(): array
    {
        return $this->items;
    }
}
