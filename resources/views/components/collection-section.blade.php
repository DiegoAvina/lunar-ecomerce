<section class="bg-white py-section-gap ">
    <div class="max-w-screen-2xl mx-auto px-8">

        <div class="flex flex-col items-center text-center mb-16">

            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">
                    {{ $collection['name'] }}
                </h2>

                <p class="font-body-md text-body-md text-secondary mt-2">
                    Descubre nuestra colección.
                </p>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">

            @foreach($collection['products'] as $product)

                <x-product-card
                    :product="$product"
                />

            @endforeach

        </div>

    </div>
</section>