<aside class="w-72 space-y-8">

    @foreach($filters as $filter)

        <div class="border-b border-gray-200 pb-6">

            <h3 class="font-semibold text-lg mb-4">

                {{ $filter->title }}

            </h3>

            <div class="space-y-3">

                @foreach($filter->options as $option)

                    <label
                        class="flex items-center justify-between cursor-pointer">

                        <div class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                value="{{ $option->value }}"
                                @checked($option->selected)
                            >

                            <span>

                                {{ $option->label }}

                            </span>

                        </div>

                        @if($option->count)

                            <span
                                class="text-gray-400 text-sm">

                                {{ $option->count }}

                            </span>

                        @endif

                    </label>

                @endforeach

            </div>

        </div>

    @endforeach
    @if($filter->key === 'price')

    <div class="space-y-2">

        <div class="flex justify-between text-sm text-gray-600">

            <span>
                ${{ number_format($filter->extra->min, 2) }}
            </span>

            <span>
                ${{ number_format($filter->extra->max, 2) }}
            </span>

        </div>

        <input
            type="range"
            min="{{ $filter->extra->min }}"
            max="{{ $filter->extra->max }}"
            value="{{ $filter->extra->selectedMax }}"
            class="w-full"
        >

    </div>

@else

    {{-- Aquí sigue el foreach de las opciones (marcas, categorías, etc.) --}}

@endif

</aside>