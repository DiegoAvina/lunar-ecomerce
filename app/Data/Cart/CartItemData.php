<?php

namespace App\Data\Cart;

final readonly class CartItemData
{
    public function __construct(
        public int $lineId,
        public int $variantId,
        public string $name,
        public ?string $sku,
        public int $quantity,
        public string $unitPrice,
        public string $total,
        public ?string $image,
    ) {}
}