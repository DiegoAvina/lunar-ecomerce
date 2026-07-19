<?php

namespace App\Services\Storefront;

use Lunar\Models\Collection;
use App\Support\LunarAttribute;
use App\Data\ProductData;
use App\Data\BrandData;



class ProductService
{
    public function __construct(

        protected ProductImageService $images,

        protected ProductPriceService $prices,

        protected ProductInventoryService $inventory,

        protected ProductBadgeService $badges,
    ) {}

    public function featured(): array
    {
        $collection = Collection::with([
            'products.brand',
            'products.variants.prices',
            'products.media',
        ])->find(config('storefront.featured_collection_id'));

        if (! $collection) {
            return [];
        }

        return $collection->products
            ->map(fn($product) => $this->map($product))
            ->toArray();
    }

    public function map($product): ProductData
{
    $variant = $product->variants->first();

    return new ProductData(

        id: $product->id,

        name: LunarAttribute::text(
            $product->attribute_data,
            'name'
        ),

        slug: null,

        brand: new BrandData(
            id: $product->brand?->id,
            name: $product->brand?->name,
        ),

        price: $this->prices->build($variant),

        inventory: $this->inventory->build($variant),

        image: $this->images->primary($product),

        gallery: $this->images->gallery($product),

        badges: $this->badges->build($product, $variant),

        url: '#',

        addToCartUrl: '#',

    );
}

/**
 * @return ProductData[]
 */
public function all(): array
{
    return \Lunar\Models\Product::with([
        'brand',
        'variants.prices',
        'media',
    ])
    ->where('status', 'published')
    ->get()
    ->map(fn ($product) => $this->map($product))
    ->toArray();
}
}
