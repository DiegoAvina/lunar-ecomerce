<?php

namespace App\Services\Storefront\Catalog\Filters;

use App\Data\FilterData;
use App\Data\FilterOptionData;
use Lunar\Models\Brand;

class BrandFilter
{
    public function build(): FilterData
    {
        $brands = Brand::query()

            ->withCount('products')

            ->whereHas('products')

            ->orderBy('name')

            ->get();

        $options = $brands->map(function ($brand) {

            return new FilterOptionData(

                value: $brand->id,

                label: $brand->name,

                count: $brand->products_count,

                selected: request('brand') == $brand->id,

            );

        })->toArray();

        return new FilterData(

            key: 'brand',

            title: 'Marcas',

            options: $options,

        );
    }
}