<?php

namespace App\Services\Storefront;

use App\Data\InventoryData;

class ProductInventoryService
{
    public function build($variant): InventoryData
    {
        return new InventoryData(

            sku: $variant?->sku,

            stock: $variant?->stock ?? 0,

            available: ($variant?->stock ?? 0) > 0,

            backorder: (bool) ($variant?->backorder ?? false),

        );
    }
}