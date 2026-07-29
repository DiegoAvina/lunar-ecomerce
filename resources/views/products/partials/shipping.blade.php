@php

$from = now()->addDays(2);

$to = now()->addDays(4);

@endphp

<div class="mt-8 rounded-3xl border border-gray-200 bg-gray-50 p-6">

    <div class="flex items-start gap-4">

        <div
            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-2xl"
        >
            📦
        </div>

        <div>

            <p class="font-semibold text-gray-900">

                Entrega estimada

            </p>

            <p class="mt-1 text-gray-600">

                Recíbelo entre

                <span class="font-semibold">

                    {{ $from->translatedFormat('d \\d\\e F') }}

                </span>

                y

                <span class="font-semibold">

                    {{ $to->translatedFormat('d \\d\\e F') }}

                </span>

            </p>

            <p class="mt-2 text-sm text-green-600">

                Envío gratis en compras mayores a $999

            </p>

        </div>

    </div>

    <div class="my-5 border-t border-gray-200"></div>

    <div class="space-y-4">

        <div class="flex items-center gap-3">

            <span class="text-lg">
                🔒
            </span>

            <span class="text-gray-700">

                Compra 100% protegida

            </span>

        </div>

        <div class="flex items-center gap-3">

            <span class="text-lg">
                ↩️
            </span>

            <span class="text-gray-700">

                Devoluciones fáciles durante 30 días

            </span>

        </div>

        <div class="flex items-center gap-3">

            <span class="text-lg">
                🛡️
            </span>

            <span class="text-gray-700">

                Garantía oficial del fabricante

            </span>

        </div>

    </div>

</div>