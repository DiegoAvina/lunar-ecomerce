@props([
    'product',
])

@php
    $name = $product->name;

    $brand = $product->brand?->name;

    $price = $product->price->formatted;

    $image = $product->image?->url
        ?? asset('images/product-placeholder.png');

    $imageAlt = $product->image?->alt
        ?? $name;

    $inventory = $product->inventory;

    $stock = $inventory->stock;

    $available = $inventory->available;

    $sku = $inventory->sku;

    $detailUrl = $product->url;

    $addToCartUrl = $product->addToCartUrl;

    $badges = $product->badges;
@endphp

<div
    class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col">

    {{-- Imagen --}}
    <div class="relative aspect-square bg-gray-50 p-8">

        {{-- Badges --}}
        <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">

            @foreach($badges as $badge)

                @php
                    $classes = match($badge->type) {

                        'danger' => 'bg-red-600 text-white',

                        'warning' => 'bg-yellow-500 text-white',

                        'success' => 'bg-green-600 text-white',

                        'info' => 'bg-blue-600 text-white',

                        default => 'bg-gray-600 text-white',

                    };
                @endphp

                <span
                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $classes }}">

                    {{ $badge->label }}

                </span>

            @endforeach

        </div>

        <img
            src="{{ $image }}"
            alt="{{ $imageAlt }}"
            class="w-full h-full object-contain group-hover:scale-105 transition duration-500">

    </div>

    {{-- Información --}}
    <div class="flex-1 flex flex-col p-6">

        @if($brand)
            <p class="text-xs uppercase tracking-widest text-gray-500">
                {{ $brand }}
            </p>
        @endif

        <h3
            class="font-semibold text-lg mt-2 line-clamp-2 min-h-[56px]">

            {{ $name }}

        </h3>

        @if($sku)
            <p class="text-xs text-gray-400 mt-2">
                SKU: {{ $sku }}
            </p>
        @endif

        <div class="mt-5">

            <p class="text-2xl font-bold text-primary">
                {{ $price }}
            </p>

        </div>

        <div class="mt-3">

            @if($available)

                <span class="text-green-600 text-sm">

                    ✔ {{ $stock }} disponibles

                </span>

            @else

                <span class="text-red-500 text-sm">

                    Sin existencias

                </span>

            @endif

        </div>

        <div class="mt-auto pt-6 flex gap-3">

            <a
                href="{{ $detailUrl }}"
                class="flex-1 border border-primary text-primary py-3 rounded-lg text-center hover:bg-primary hover:text-white transition">

                Ver producto

            </a>

            <a
                href="{{ $addToCartUrl }}"
                class="bg-primary text-white px-5 rounded-lg flex items-center justify-center hover:opacity-90 transition">

                <span class="material-symbols-outlined">

                    shopping_cart

                </span>

            </a>

        </div>

    </div>

</div>