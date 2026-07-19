<section class="bg-white py-20 border-y border-gray-100">
    <div class="max-w-screen-2xl mx-auto px-8">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-semibold text-gray-900">
                Marcas que distribuimos
            </h2>

            <p class="text-gray-500 mt-3">
                Trabajamos con fabricantes líderes en tecnología.
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 place-items-center">

            @foreach($brands as $brand)

                <div class="w-full max-w-[180px] min-h-[96px] border border-gray-200 rounded-xl p-6 bg-white text-center transition duration-300 ease-out hover:-translate-y-1 hover:shadow-sm hover:border-gray-300 hover:bg-gray-50 flex items-center justify-center">

                    <h3 class="font-medium text-gray-700">
                        {{ $brand['name'] }}
                    </h3>

                </div>

            @endforeach

        </div>

    </div>
</section>