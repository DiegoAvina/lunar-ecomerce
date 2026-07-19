{{--
    Componente: Search Bar
    Uso: @include('components.search') o <x-search />

    Props opcionales:
        $placeholder  → texto del input  (default: 'Buscar...')
        $class        → clases extra para el contenedor
--}}

@props([
    'placeholder' => 'Buscar...',
    'class'       => '',
])

{{-- Desktop search bar --}}
<div class="hidden sm:flex items-center border-b border-outline-variant px-2 py-1 focus-within:border-primary transition-colors {{ $class }}">
    <span class="material-symbols-outlined text-outline text-sm" data-icon="search">search</span>
    <input
        class="bg-transparent border-none focus:ring-0 text-sm font-light w-32 md:w-48 placeholder-secondary/50"
        placeholder="{{ $placeholder }}"
        type="text"
        name="q"
    />
</div>

{{-- Mobile search icon (visible solo en pantallas pequeñas, lógica de toggle a cargo del padre) --}}
<button class="lg:hidden text-secondary hover:text-primary transition-colors" aria-label="Abrir búsqueda">
    <span class="material-symbols-outlined" data-icon="search">search</span>
</button>
