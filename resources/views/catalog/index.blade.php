<div class="container mx-auto py-16">

    <h1 class="text-4xl font-bold mb-10">

        Catálogo

    </h1>

    <div class="grid grid-cols-12 gap-10">

        <div class="col-span-3">

            <x-catalog.sidebar
                :filters="$catalog->filters"
            />

        </div>

        <div class="col-span-9">

            <div
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach($catalog->products as $product)

                    <x-product-card
                        :product="$product"
                    />

                @endforeach

            </div>

        </div>

    </div>

</div>