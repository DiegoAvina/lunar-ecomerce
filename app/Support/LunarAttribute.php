<?php

namespace App\Support;

use Illuminate\Support\Collection;

class LunarAttribute
{
    /**
     * Obtiene un atributo traducido de Lunar.
     */
    public static function text(
    Collection|array $attributes,
    string $field,
    string $locale = 'es'
): ?string {

    $attribute = $attributes[$field] ?? null;

    if (! $attribute) {
        return null;
    }

    $translations = $attribute->getValue();

    if (! isset($translations[$locale])) {
        return null;
    }

    return $translations[$locale]->getValue();
}
}