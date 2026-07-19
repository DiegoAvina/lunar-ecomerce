<?php

namespace App\Data;

final readonly class CatalogData
{
    /**
     * @param ProductData[] $products
     */
    public function __construct(

        public array $products,

        public array $filters = [],

        public array $sort = [],

        public ?string $search = null,

        public ?array $pagination = null,

    ) {
    }
}