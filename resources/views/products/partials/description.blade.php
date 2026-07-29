<div class="bg-white rounded-2xl p-8 shadow-sm">

    <h2 class="text-2xl font-bold mb-6">
        Descripción
    </h2>

    @if($product->description)
        <div class="prose max-w-none">
            {!! $product->description !!}
        </div>
    @else
        <p class="text-gray-500">
            Este producto no tiene descripción.
        </p>
    @endif

</div>