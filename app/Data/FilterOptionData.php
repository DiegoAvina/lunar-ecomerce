<?php

namespace App\Data;

final readonly class FilterOptionData
{
    public function __construct(

        public string|int $value,

        public string $label,

        public int $count = 0,

        public bool $selected = false,

    ) {
    }
}