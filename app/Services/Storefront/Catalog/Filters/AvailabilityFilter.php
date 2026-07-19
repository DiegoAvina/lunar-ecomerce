<?php

namespace App\Services\Storefront\Catalog\Filters;

use App\Data\FilterData;
use App\Data\FilterOptionData;

class AvailabilityFilter
{
    public function build(): FilterData
    {
        return new FilterData(

            key: 'availability',

            title: 'Disponibilidad',

            options: [

                new FilterOptionData(

                    value: 1,

                    label: 'Disponible',

                ),

                new FilterOptionData(

                    value: 0,

                    label: 'Agotado',

                ),

            ],

        );
    }
}