<div class="sticky top-8 rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">

    {{-- Marca --}}
    <p class="text-xs font-semibold uppercase tracking-[0.30em] text-blue-700">
        {{ $product->brand->name }}
    </p>

    {{-- Nombre --}}
    <h1 class="mt-3 text-4xl lg:text-5xl font-extrabold leading-tight text-gray-900">
        {{ $product->name }}
    </h1>

    {{-- SKU --}}
    @if($product->inventory->sku)
        <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
            <span class="font-medium">SKU:</span>
            <span>{{ $product->inventory->sku }}</span>
        </div>
    @endif

    {{-- Separador --}}
    <div class="my-8 border-t border-gray-200"></div>

    {{-- Precio --}}
    <div>
        <p class="text-5xl font-black tracking-tight text-gray-900">
            {{ $product->price->formatted }}
        </p>

        <p class="mt-2 text-sm text-gray-500">
            Precio con IVA incluido.
        </p>
    </div>

    {{-- Stock --}}
    <div class="mt-8">

        @if($product->inventory->available)

            <div class="flex items-center gap-3">
                <span class="h-3 w-3 rounded-full bg-green-500"></span>

                <span class="font-semibold text-green-700">
                    Disponible
                </span>
            </div>

            <p class="mt-2 text-sm text-gray-500">
                {{ $product->inventory->stock }}
                piezas disponibles para entrega inmediata.
            </p>

        @elseif($product->inventory->backorder)

            <div class="flex items-center gap-3">
                <span class="h-3 w-3 rounded-full bg-yellow-500"></span>

                <span class="font-semibold text-yellow-700">
                    Disponible bajo pedido
                </span>
            </div>

            <p class="mt-2 text-sm text-gray-500">
                El tiempo de entrega puede variar.
            </p>

        @else

            <div class="flex items-center gap-3">
                <span class="h-3 w-3 rounded-full bg-red-500"></span>

                <span class="font-semibold text-red-700">
                    Agotado
                </span>
            </div>

        @endif

    </div>

    {{-- Separador --}}
    <div class="my-8 border-t border-gray-200"></div>

    {{-- Cantidad --}}
    <div
        x-data="{ qty:1 }"
    >

        <label class="mb-4 block text-sm font-semibold text-gray-700">
            Cantidad
        </label>

        <div class="flex w-44 items-center overflow-hidden rounded-2xl border border-gray-300">

            <button
                @click="if(qty > 1) qty--"
                class="flex h-12 w-12 items-center justify-center text-xl font-semibold transition hover:bg-gray-100"
            >
                −
            </button>

            <input
                x-model="qty"
                type="number"
                min="1"
                class="w-full border-0 text-center font-semibold focus:ring-0"
            >

            <button
                @click="qty++"
                class="flex h-12 w-12 items-center justify-center text-xl font-semibold transition hover:bg-gray-100"
            >
                +
            </button>

        </div>

    </div>

    {{-- Botones --}}
    <div class="mt-10 space-y-4">

        <button
            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-700 px-6 py-4 text-lg font-semibold text-white transition hover:bg-blue-800"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 5h13M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
            </svg>

            Agregar al carrito
        </button>

        <button
            class="w-full rounded-2xl border-2 border-blue-700 px-6 py-4 text-lg font-semibold text-blue-700 transition hover:bg-blue-50"
        >
            Comprar ahora
        </button>

    </div>
    @include('products.partials.shipping')

    {{-- Beneficios --}}
    <div class="mt-10 rounded-2xl border border-gray-200 bg-gray-50 p-6">

        <h3 class="mb-5 font-semibold text-gray-900">
            ¿Por qué comprar con nosotros?
        </h3>

        <div class="space-y-4">

            <div class="flex items-start gap-3">

                <span class="text-green-600">✓</span>

                <div>
                    <p class="font-medium text-gray-900">
                        Pago 100% seguro
                    </p>

                    <p class="text-sm text-gray-500">
                        Todas las transacciones están protegidas.
                    </p>
                </div>

            </div>

            <div class="flex items-start gap-3">

                <span class="text-green-600">✓</span>

                <div>
                    <p class="font-medium text-gray-900">
                        Envíos a todo México
                    </p>

                    <p class="text-sm text-gray-500">
                        Entregas rápidas mediante paqueterías confiables.
                    </p>
                </div>

            </div>

            <div class="flex items-start gap-3">

                <span class="text-green-600">✓</span>

                <div>
                    <p class="font-medium text-gray-900">
                        Garantía del fabricante
                    </p>

                    <p class="text-sm text-gray-500">
                        Todos nuestros productos cuentan con garantía oficial.
                    </p>
                </div>

            </div>

            <div class="flex items-start gap-3">

                <span class="text-green-600">✓</span>

                <div>
                    <p class="font-medium text-gray-900">
                        Atención personalizada
                    </p>

                    <p class="text-sm text-gray-500">
                        Nuestro equipo puede ayudarte antes y después de tu compra.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>