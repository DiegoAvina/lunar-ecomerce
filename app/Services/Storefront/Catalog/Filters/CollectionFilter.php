<?php

namespace App\Services\Storefront\Catalog\Filters;

use App\Data\FilterData;
use App\Data\FilterOptionData;
use App\Support\LunarAttribute;
use Lunar\Models\Collection;

class CollectionFilter
{
    public function build(): FilterData
    {
        $collections = Collection::query()

            ->withCount('products')

            ->whereHas('products')

            ->orderBy('_lft')

            ->get();

        $options = $collections->map(function ($collection) {

            return new FilterOptionData(

                value: $collection->id,

                label: LunarAttribute::text(
                    $collection->attribute_data,
                    'name'
                ),

                count: $collection->products_count,

                selected: request('collection') == $collection->id,

            );

        })->toArray();

        return new FilterData(

            key: 'collection',

            title: 'Categorías',

            options: $options,

        );
    }
}