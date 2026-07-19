<?php

namespace App\Services\Storefront\Catalog;

use App\Data\CatalogData;
use App\Services\Storefront\ProductService;

class CatalogService
{
    public function __construct(

        protected ProductService $products,

        protected CatalogFilterService $filters,

        protected CatalogSortService $sort,

    ) {}

    public function data(): CatalogData
    {

        return new CatalogData(

            products: $this->products->all(),

            filters: $this->filters->build(),

            sort: $this->sort->options(),

            search: request('q'),

            pagination: null,

        );
    }
}
