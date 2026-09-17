@php
$variantId = $product->variantId;

$stock = (int) ($product->inventory->stock ?? 0);

$backorder = (bool) ($product->inventory->backorder ?? false);

/*
|--------------------------------------------------------------------------
| Disponibilidad real
|--------------------------------------------------------------------------
|
| La existencia de Lunar es la fuente de verdad.
|
| stock > 0
| → Disponible
|
| stock = 0 + backorder
| → Disponible bajo pedido
|
| stock = 0 + sin backorder
| → Agotado
|
*/

$available = $stock > 0;

$canPurchase = $variantId && (
$stock > 0 || $backorder
);
@endphp



<div
    x-data='{
    qty: 1,

    loading: false,

    added: false,

    error: null,

    maxStock: {{ $stock }},

    variantId: {{ $variantId ?? "null" }},

    backorder: {{ $backorder ? "true" : "false" }},


    /*
    |--------------------------------------------------------------------------
    | Agregar al carrito
    |--------------------------------------------------------------------------
    */

    async addToCart() {

        if (this.loading) {
            return;
        }

        if (!this.variantId) {

            this.error =
                "Este producto no tiene una variante disponible.";

            return;
        }

        this.validateQuantity();

        if (this.error) {
            return;
        }

        this.loading = true;

        this.added = false;

        this.error = null;


        try {

            const csrfElement =
                document.querySelector(
                    "meta[name=\"csrf-token\"]"
                );


            if (!csrfElement) {

                throw new Error(
                    "No se encontró el token CSRF."
                );

            }


            const response = await fetch(
                "{{ $product->addToCartUrl }}",
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",

                        "Accept": "application/json",

                        "X-CSRF-TOKEN":
                            csrfElement.content
                    },

                    body: JSON.stringify({

                        variant_id:
                            this.variantId,

                        quantity:
                            this.qty

                    })
                }
            );

const contentType =
    response.headers.get("content-type") || "";

let data;

if (contentType.includes("application/json")) {

    data = await response.json();

} else {

    const text = await response.text();

    console.error(
        "Respuesta no JSON del servidor:",
        text
    );

    throw new Error(
        "El servidor devolvió una respuesta inesperada."
    );
}


console.log(
    "CARRITO:",
    data
);

            if (!response.ok) {

                throw new Error(
                    data?.message ||
                    "No se pudo agregar el producto al carrito."
                );

            }


            if (!data.success) {

                throw new Error(
                    data?.message ||
                    "No se pudo agregar el producto al carrito."
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Producto agregado correctamente
            |--------------------------------------------------------------------------
            */

            this.added = true;


            /*
            |--------------------------------------------------------------------------
            | Notificar al resto de la tienda
            |--------------------------------------------------------------------------
            */

            window.dispatchEvent(

                new CustomEvent(
                    "cart-updated",
                    {
                        detail: data.cart
                    }
                )

            );


            /*
            |--------------------------------------------------------------------------
            | Ocultar mensaje después de unos segundos
            |--------------------------------------------------------------------------
            */

            setTimeout(() => {

                this.added = false;

            }, 3000);


        } catch (error) {

            console.error(
                "Error agregando al carrito:",
                error
            );


            this.error =
                error.message ||
                "Ocurrió un error al agregar el producto.";


        } finally {

            this.loading = false;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Comprar ahora
    |--------------------------------------------------------------------------
    */

    async buyNow() {

        if (this.loading) {
            return;
        }


        if (!this.variantId) {

            this.error =
                "Este producto no tiene una variante disponible.";

            return;
        }


        this.validateQuantity();


        if (this.error) {
            return;
        }


        this.loading = true;

        this.error = null;


        try {

            const csrfElement =
                document.querySelector(
                    "meta[name=\"csrf-token\"]"
                );


            if (!csrfElement) {

                throw new Error(
                    "No se encontró el token CSRF."
                );

            }


            const response = await fetch(
                "{{ $product->addToCartUrl }}",
                {
                    method: "POST",

                    headers: {

                        "Content-Type":
                            "application/json",

                        "Accept":
                            "application/json",

                        "X-CSRF-TOKEN":
                            csrfElement.content

                    },

                    body: JSON.stringify({

                        variant_id:
                            this.variantId,

                        quantity:
                            this.qty

                    })

                }
            );


            const contentType =
    response.headers.get("content-type") || "";

let data;

if (contentType.includes("application/json")) {

    data = await response.json();

} else {

    const text = await response.text();

    console.error(
        "Respuesta no JSON del servidor:",
        text
    );

    throw new Error(
        "El servidor devolvió una respuesta inesperada."
    );
}


console.log(
    "COMPRA AHORA:",
    data
);


if (!response.ok) {

    throw new Error(
        data?.message ||
        "No se pudo agregar el producto al carrito."
    );

}


if (!data.success) {

    throw new Error(
        data?.message ||
        "No se pudo agregar el producto al carrito."
    );

}

            /*
            |--------------------------------------------------------------------------
            | Actualizar carrito
            |--------------------------------------------------------------------------
            */

            window.dispatchEvent(

                new CustomEvent(
                    "cart-updated",
                    {
                        detail: data.cart
                    }
                )

            );


            /*
            |--------------------------------------------------------------------------
            | Ir al checkout
            |--------------------------------------------------------------------------
            */

            window.location.href =
                "{{ route('checkout.index') }}";


        } catch (error) {

            console.error(
                "Error en comprar ahora:",
                error
            );


            this.error =
                error.message ||
                "Ocurrió un error al procesar la compra.";


        } finally {

            this.loading = false;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Aumentar cantidad
    |--------------------------------------------------------------------------
    */
increase() {

    if (this.loading) {
        return;
    }

    if (this.backorder) {
        this.qty++;
        return;
    }

    if (this.maxStock <= 0) {
        return;
    }

    if (this.qty >= this.maxStock) {
        this.qty = this.maxStock;
        return;
    }

    this.qty++;
},


    /*
    |--------------------------------------------------------------------------
    | Disminuir cantidad
    |--------------------------------------------------------------------------
    */

    decrease() {

        if (this.loading) {
            return;
        }


        if (this.qty > 1) {

            this.qty--;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Validar cantidad
    |--------------------------------------------------------------------------
    */

    validateQuantity() {

        /*
        | Nunca permitir cantidades menores
        | a una unidad.
        */

        if (
            !this.qty ||
            this.qty < 1
        ) {

            this.qty = 1;

        }


        /*
        | Bajo pedido
        |
        | Puede solicitarse una cantidad mayor
        | al stock disponible.
        */

        if (this.backorder) {

            this.error = null;

            return;

        }


        /*
        | Producto normal
        |
        | No podemos vender más unidades
        | de las existentes.
        */

        if (
            this.maxStock <= 0
        ) {

            this.qty = 1;

            this.error =
                "Este producto está agotado.";

            return;

        }


        if (
            this.qty > this.maxStock
        ) {

            this.qty =
                this.maxStock;

            this.error =
                `Solo hay ${this.maxStock} piezas disponibles.`;

            return;

        }


        this.error = null;

    }

}'

    class="sticky top-28 rounded-[2rem] border border-outline-variant/30 bg-white p-8 shadow-sm">


    {{-- ================================================================ --}}
    {{-- MARCA --}}
    {{-- ================================================================ --}}

    <p
        class="font-label-md text-label-md text-primary">
        {{ $product->brand->name }}
    </p>


    {{-- ================================================================ --}}
    {{-- NOMBRE --}}
    {{-- ================================================================ --}}

    <h1
        class="mt-3 text-4xl font-extrabold leading-tight text-on-surface lg:text-5xl">
        {{ $product->name }}
    </h1>


    {{-- ================================================================ --}}
    {{-- SKU --}}
    {{-- ================================================================ --}}

    @if($product->inventory->sku)

    <div
        class="mt-4 flex items-center gap-2 text-sm text-secondary">

        <span class="font-medium">
            SKU:
        </span>

        <span>
            {{ $product->inventory->sku }}
        </span>

    </div>

    @endif


    {{-- ================================================================ --}}
    {{-- SEPARADOR --}}
    {{-- ================================================================ --}}

    <div class="my-8 border-t border-outline-variant/30"></div>


    {{-- ================================================================ --}}
    {{-- PRECIO --}}
    {{-- ================================================================ --}}

    <div>

        <p
            class="text-5xl font-black tracking-tight text-on-surface tabular-nums">
            {{ $product->price->formatted }}
        </p>

        <p
            class="mt-2 text-sm text-secondary">
            Precio con IVA incluido.
        </p>

    </div>


    {{-- ================================================================ --}}
    {{-- DISPONIBILIDAD --}}
    {{-- ================================================================ --}}

    <div class="mt-8">

        @if($available)

        <div class="flex items-center gap-3">

            <span class="relative flex h-3 w-3">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-3 w-3 rounded-full bg-emerald-500"></span>
            </span>

            <span
                class="font-semibold text-emerald-700">
                Disponible
            </span>

        </div>

        <p class="mt-2 text-sm text-secondary">

            {{ $stock }}

            {{ $stock === 1 ? 'pieza disponible' : 'piezas disponibles' }}

            para entrega.

        </p>

        @elseif($backorder)

        <div class="flex items-center gap-3">

            <span
                class="h-3 w-3 rounded-full bg-amber-500"></span>

            <span
                class="font-semibold text-amber-700">
                Disponible bajo pedido
            </span>

        </div>

        <p class="mt-2 text-sm text-secondary">
            El tiempo de entrega puede variar según disponibilidad del proveedor.
        </p>

        @else

        <div class="flex items-center gap-3">

            <span
                class="h-3 w-3 rounded-full bg-red-500"></span>

            <span
                class="font-semibold text-red-700">
                Agotado
            </span>

        </div>

        <p class="mt-2 text-sm text-secondary">
            Actualmente no tenemos unidades disponibles.
        </p>

        @endif

    </div>


    {{-- ================================================================ --}}
    {{-- SEPARADOR --}}
    {{-- ================================================================ --}}

    <div class="my-8 border-t border-outline-variant/30"></div>


    {{-- ================================================================ --}}
    {{-- CANTIDAD --}}
    {{-- ================================================================ --}}

    <div>

        <label
            class="mb-4 block text-sm font-semibold text-on-surface">
            Cantidad
        </label>


        <div
            class="flex w-44 items-center overflow-hidden rounded-2xl border border-outline-variant">

            <button
                type="button"
                @click="decrease()"
                :disabled="loading || qty <= 1"
                class="flex h-12 w-12 items-center justify-center text-xl font-semibold text-on-surface transition hover:bg-surface-container-low disabled:cursor-not-allowed disabled:opacity-40"
                aria-label="Disminuir cantidad">
                −
            </button>


            <input
                x-model.number="qty"
                @input="validateQuantity()"
                @change="validateQuantity()"
                type="number"
                min="1"
                :disabled="
        loading ||
        {{ $canPurchase ? 'false' : 'true' }}
    "
                class="w-full border-0 text-center font-semibold text-on-surface focus:ring-0"
                aria-label="Cantidad">


            <button
                type="button"
                @click="increase()"
                :disabled="
                    loading ||
                    (
                        !backorder &&
                        maxStock > 0 &&
                        qty >= maxStock
                    )
                "
                class="flex h-12 w-12 items-center justify-center text-xl font-semibold text-on-surface transition hover:bg-surface-container-low disabled:cursor-not-allowed disabled:opacity-40"
                aria-label="Aumentar cantidad">
                +
            </button>

        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- ERROR --}}
    {{-- ================================================================ --}}

    <template x-if="error">

        <div
            class="mt-5 flex items-start gap-3 rounded-2xl border border-error/20 bg-error-container px-4 py-4 text-sm text-on-error-container">

            <span class="material-symbols-outlined">
                error
            </span>

            <p x-text="error"></p>

        </div>

    </template>


    {{-- ================================================================ --}}
    {{-- BOTONES --}}
    {{-- ================================================================ --}}

    <div class="mt-10 space-y-4">


        {{-- AGREGAR AL CARRITO --}}
        {{-- Agregar al carrito --}}
        <button
            type="button"
            @click="addToCart()"
            :disabled="
        loading ||
        {{ $canPurchase ? 'false' : 'true' }}
    "
            class="flex w-full items-center justify-center gap-3 rounded-2xl bg-primary px-6 py-4 text-lg font-semibold text-on-primary shadow-lg shadow-primary/20 transition hover:brightness-110 hover:shadow-primary/30 disabled:cursor-not-allowed disabled:bg-surface-container disabled:text-secondary disabled:shadow-none">
            <template x-if="loading">
                <svg
                    class="h-5 w-5 animate-spin"
                    viewBox="0 0 24 24"
                    fill="none">
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke="currentColor"
                        stroke-width="3"
                        class="opacity-30" />

                    <path
                        d="M21 12a9 9 0 0 1-9 9"
                        stroke="currentColor"
                        stroke-width="3"
                        stroke-linecap="round" />
                </svg>
            </template>

            <template x-if="!loading && !added">
                <span class="material-symbols-outlined">
                    shopping_cart
                </span>
            </template>

            <template x-if="!loading && added">
                <span class="material-symbols-outlined">
                    check_circle
                </span>
            </template>

            <span
                x-text="
            loading
                ? 'Agregando...'
                : added
                    ? 'Agregado al carrito'
                    : 'Agregar al carrito'
        "></span>
        </button>


        {{-- Comprar ahora --}}
        <button
            type="button"
            @click="buyNow()"
            :disabled="
        loading ||
        {{ $canPurchase ? 'false' : 'true' }}
    "
            class="flex w-full items-center justify-center gap-2 rounded-2xl border-2 border-primary px-6 py-4 text-lg font-semibold text-primary transition hover:bg-surface-container-low disabled:cursor-not-allowed disabled:border-outline-variant disabled:text-secondary">
            <span class="material-symbols-outlined">
                bolt
            </span>

            Comprar ahora
        </button>








    </div>


    {{-- ================================================================ --}}
    {{-- ENVÍO --}}
    {{-- ================================================================ --}}

    @include('products.partials.shipping')


    {{-- ================================================================ --}}
    {{-- BENEFICIOS --}}
    {{-- ================================================================ --}}

    <div
        class="mt-10 rounded-2xl border border-outline-variant/30 bg-surface-container-low p-6">

        <h3
            class="mb-5 font-semibold text-on-surface">
            ¿Por qué comprar con nosotros?
        </h3>


        <div class="space-y-4">

            @foreach([
                ['title' => 'Pago 100% seguro', 'text' => 'Todas las transacciones están protegidas.'],
                ['title' => 'Envíos a todo México', 'text' => 'Entregas mediante paqueterías confiables.'],
                ['title' => 'Garantía del fabricante', 'text' => 'Todos nuestros productos cuentan con garantía oficial.'],
                ['title' => 'Atención personalizada', 'text' => 'Nuestro equipo puede ayudarte antes y después de tu compra.'],
            ] as $reason)

            <div class="flex items-start gap-3">

                <span class="material-symbols-outlined text-lg text-primary">
                    check_circle
                </span>

                <div>

                    <p class="font-medium text-on-surface">
                        {{ $reason['title'] }}
                    </p>

                    <p class="text-sm text-secondary">
                        {{ $reason['text'] }}
                    </p>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>