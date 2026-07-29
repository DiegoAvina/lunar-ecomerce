@extends('layouts.app')

@section('title', $product->name)
@section('content')

<div class="bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-8 text-sm text-gray-500">
            Inicio /
            {{ $product->brand->name }}
            /
            {{ $product->name }}
        </nav>

        {{-- Hero --}}
        <div class="bg-white rounded-2xl shadow-sm p-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

                @include('products.partials.gallery')

                @include('products.partials.info')

            </div>

        </div>

        <div class="mt-14">

            @include('products.partials.description')

        </div>

        <div class="mt-14">

            @include('products.partials.specifications')

        </div>

        <div class="mt-16">

            @include('products.partials.related-products')

        </div>

    </div>

</div>

@endsection