<?php

namespace App\Data;

final readonly class InventoryData
{
    public function __construct(

        public ?string $sku,

        public int $stock,

        public bool $available,

        public bool $backorder,

    ) {
    }
}