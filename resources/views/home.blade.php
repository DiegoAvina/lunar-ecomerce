{{--
    Vista: Home / Página de inicio
    Extiende: layouts/app.blade.php

    Ensambla hero, galería de productos y banner de innovación.
    Los datos de productos y slides pueden venir del controlador.
--}}

@extends('layouts.app')

@section('title', 'Optidigital | Innovando tu Mundo')

@section('content')

{{-- ── Hero Carousel ───────────────────────────────────────────────── --}}
@include('partials.hero')

{{-- ── Divider ─────────────────────────────────────────────────────── --}}
<div class="max-w-screen-2xl mx-auto px-8">
    <hr class="border-gray-100" />
</div>


@include('partials.brands')

@foreach($collections as $collection)

<x-collection-section
    :collection="$collection" />

@endforeach

{{-- ── Innovation Banner ───────────────────────────────────────────── --}}
<section class="bg-surface-container-low py-section-gap">
    <div class="max-w-screen-2xl mx-auto px-8 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-6 lg:col-start-4 text-center">
            <h2 class="font-display-lg text-display-lg mb-8">Innovación</h2>
            <p class="font-body-lg text-body-lg text-secondary mb-12">
                Nuestra búsqueda de la perfección es incansable. Cada milímetro de un dispositivo Optidigital
                es analizado para asegurar que cumple con el estándar de Precisión Digital.
            </p>
            <a href="#"
                class="inline-block border border-primary text-primary px-12 py-5
                          font-label-md text-label-md uppercase
                          hover:bg-primary hover:text-white transition-all">
                Descubre el Centro de Innovación
            </a>
        </div>
    </div>
</section>

@endsection