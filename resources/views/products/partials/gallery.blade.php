<div
    x-data="{
        images: @js($product->gallery),
        index: 0,
        lightbox: false,
        zoom: false,
        x:50,
        y:50,

        init() {
            if(this.images.length === 0){
                this.images = [{
                    url: @js($product->image?->url),
                    alt: @js($product->image?->alt)
                }];
            }
        },

        get current(){
            return this.images[this.index];
        },

        next(){
            this.index = (this.index + 1) % this.images.length;
        },

        prev(){
            this.index = (this.index - 1 + this.images.length) % this.images.length;
        },

        move(e){
            const rect = e.target.getBoundingClientRect();

            this.x = ((e.clientX - rect.left) / rect.width) * 100;
            this.y = ((e.clientY - rect.top) / rect.height) * 100;
        }
    }"

    @keydown.escape.window="lightbox=false"
    @keydown.arrow-right.window="if(lightbox) next()"
    @keydown.arrow-left.window="if(lightbox) prev()"

    class="space-y-6"
>

    {{-- Imagen principal --}}
    <div
        class="group relative overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-lg"
    >

        {{-- Badges --}}
        @if(count($product->badges))

            <div class="absolute left-5 top-5 z-30 flex flex-wrap gap-2">

                @foreach($product->badges as $badge)

                    <span class="rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white shadow">

                        {{ $badge->label }}

                    </span>

                @endforeach

            </div>

        @endif

        <div

            class="relative aspect-square overflow-hidden cursor-zoom-in bg-white"

            @mouseenter="zoom=true"

            @mouseleave="zoom=false"

            @mousemove="move($event)"

            @click="lightbox=true"

        >

            <img

                :src="current.url"

                :alt="current.alt"

                class="h-full w-full object-contain p-6 transition duration-300 ease-out"

                :style="zoom
                    ? `transform:scale(2);
                       transform-origin:${x}% ${y}%`
                    : 'transform:scale(1)'"

                draggable="false"

            >

        </div>

    </div>

    {{-- Miniaturas --}}

    <div class="grid grid-cols-4 gap-4 sm:grid-cols-5 lg:grid-cols-6">

        <template

            x-for="(image,i) in images"

            :key="i"

        >

            <button

                @click="index=i"

                class="overflow-hidden rounded-2xl border bg-white transition"

                :class="index===i
                    ? 'ring-2 ring-blue-600 border-blue-600 shadow-lg scale-105'
                    : 'border-gray-200 hover:border-blue-300 hover:shadow'"

            >

                <img

                    :src="image.url"

                    :alt="image.alt"

                    class="aspect-square w-full object-cover"

                >

            </button>

        </template>

    </div>

    {{-- LIGHTBOX --}}

    <div

        x-show="lightbox"

        x-transition.opacity

        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90"

        style="display:none"

    >

        {{-- Cerrar --}}

        <button

            @click="lightbox=false"

            class="absolute right-6 top-6 rounded-full bg-white p-3 shadow"

        >

            ✕

        </button>

        {{-- Flecha izquierda --}}

        <button

            @click="prev()"

            class="absolute left-6 rounded-full bg-white p-4 shadow"

        >

            ‹

        </button>

        {{-- Imagen --}}

        <img

            :src="current.url"

            :alt="current.alt"

            class="max-h-[90vh] max-w-[90vw] object-contain"

        >

        {{-- Flecha derecha --}}

        <button

            @click="next()"

            class="absolute right-6 rounded-full bg-white p-4 shadow"

        >

            ›

        </button>

    </div>

</div>