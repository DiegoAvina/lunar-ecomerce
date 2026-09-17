@extends('layouts.app')

@section('title', 'Checkout | Optidigital')

@section('content')

<div class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-7xl px-6 py-10">

        {{-- ========================================================= --}}
        {{-- ENCABEZADO --}}
        {{-- ========================================================= --}}

        <div class="mb-10">

            <h1 class="text-3xl font-black text-gray-900">
                Finalizar compra
            </h1>

            <p class="mt-2 text-gray-500">
                Completa tus datos para continuar con tu pedido.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- PROGRESO --}}
        {{-- ========================================================= --}}

        <div class="mb-10 overflow-hidden rounded-2xl border border-gray-200 bg-white">

            <div class="grid grid-cols-4">

                <div class="border-b-4 border-blue-700 px-6 py-5">

                    <p class="text-xs font-bold uppercase tracking-wider text-blue-700">
                        Paso 1
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        Carrito
                    </p>

                </div>


                <div class="border-b-4 border-gray-200 px-6 py-5">

                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Paso 2
                    </p>

                    <p class="mt-1 font-semibold text-gray-400">
                        Dirección
                    </p>

                </div>


                <div class="border-b-4 border-gray-200 px-6 py-5">

                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Paso 3
                    </p>

                    <p class="mt-1 font-semibold text-gray-400">
                        Envío y pago
                    </p>

                </div>


                <div class="border-b-4 border-gray-200 px-6 py-5">

                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Paso 4
                    </p>

                    <p class="mt-1 font-semibold text-gray-400">
                        Confirmación
                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- CHECKOUT --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">


            {{-- ===================================================== --}}
            {{-- DIRECCIÓN --}}
            {{-- ===================================================== --}}

            <section class="lg:col-span-2">

                <div class="rounded-2xl border border-gray-200 bg-white p-8">

                    <div class="mb-8">

                        <p class="text-sm font-semibold text-blue-700">
                            PASO 2
                        </p>

                        <h2 class="mt-1 text-2xl font-bold text-gray-900">
                            Dirección de envío
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Selecciona o agrega la dirección donde deseas recibir tu pedido.
                        </p>

                    </div>


                    {{-- Próximamente --}}
                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center">

                        <span class="material-symbols-outlined text-5xl text-gray-300">
                            location_on
                        </span>

                        <h3 class="mt-4 font-semibold text-gray-800">
                            Aún no tienes una dirección seleccionada
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                            En el siguiente paso agregaremos tus direcciones de envío y selección de domicilio.
                        </p>

                        <button
                            type="button"
                            disabled
                            class="mt-6 rounded-xl bg-gray-300 px-6 py-3 font-semibold text-gray-500 cursor-not-allowed"
                        >
                            Agregar dirección
                        </button>

                    </div>

                </div>

            </section>


            {{-- ===================================================== --}}
            {{-- RESUMEN --}}
            {{-- ===================================================== --}}

            <aside>

                <div class="sticky top-28 rounded-2xl border border-gray-200 bg-white p-6">

                    <h2 class="text-xl font-bold text-gray-900">
                        Resumen del pedido
                    </h2>


                    {{-- Productos --}}

                    <div class="mt-6 space-y-4">

                        @foreach($cart->items as $item)

                            <div class="flex gap-4">

                                <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-50">

                                    @if($item->image)

                                        <img
                                            src="{{ $item->image }}"
                                            alt="{{ $item->name }}"
                                            class="h-full w-full object-contain"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center">

                                            <span class="material-symbols-outlined text-gray-300">
                                                image
                                            </span>

                                        </div>

                                    @endif

                                </div>


                                <div class="min-w-0 flex-1">

                                    <p class="truncate font-semibold text-gray-900">
                                        {{ $item->name }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Cantidad: {{ $item->quantity }}
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ $item->total }}
                                    </p>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- Totales --}}

                    <div class="mt-6 border-t border-gray-200 pt-6">

                        <div class="flex justify-between">

                            <span class="text-sm text-gray-500">
                                Subtotal
                            </span>

                            <span class="font-semibold text-gray-900">
                                {{ $cart->subtotal }}
                            </span>

                        </div>


                        <div class="mt-3 flex justify-between">

                            <span class="text-sm text-gray-500">
                                IVA
                            </span>

                            <span class="text-sm text-gray-700">
                                {{ $cart->tax }}
                            </span>

                        </div>


                        <div class="mt-3 flex justify-between">

                            <span class="text-sm text-gray-500">
                                Envío
                            </span>

                            <span class="text-sm text-gray-700">
                                {{ $cart->shipping }}
                            </span>

                        </div>


                        <div class="mt-5 flex justify-between border-t border-gray-200 pt-5">

                            <span class="text-lg font-bold text-gray-900">
                                Total
                            </span>

                            <span class="text-2xl font-black text-gray-900">
                                {{ $cart->total }}
                            </span>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</div>

@endsection