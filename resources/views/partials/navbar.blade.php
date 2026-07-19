{{--
    Partial: Navbar / Top Navigation Bar
    Incluir con: @include('partials.navbar')

    Depende de:
        - components/search.blade.php  → barra de búsqueda integrada
        - Variable $navLinks (opcional) inyectada desde el controlador o config
          Si no existe, usa los enlaces por defecto.
--}}

@php
    $navLinks = $navLinks ?? [
        ['label' => 'Comprar Dispositivos', 'url' => '#', 'active' => true],
        ['label' => 'Soluciones',            'url' => '#', 'active' => false],
        ['label' => 'Soporte',               'url' => '#', 'active' => false],
        ['label' => 'Centro de Innovación',  'url' => '#', 'active' => false],
    ];
@endphp

<header class="bg-white dark:bg-gray-950 w-full border-b border-gray-100 dark:border-gray-900 shadow-none sticky top-0 z-50">
    <div class="max-w-screen-2xl mx-auto px-8 h-20 flex justify-between items-center font-inter tracking-tight antialiased">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter text-primary dark:text-blue-500 uppercase">
            Optidigital
        </a>

        {{-- Navegación principal --}}
        <nav class="hidden lg:flex items-center gap-8" aria-label="Navegación principal">
            @foreach ($navLinks as $link)
                <a
                    href="{{ $link['url'] }}"
                    class="{{ $link['active']
                        ? 'text-primary dark:text-blue-400 font-semibold border-b border-primary dark:border-blue-400'
                        : 'text-secondary dark:text-gray-400 font-medium hover:text-primary transition-colors duration-300'
                    }}"
                    @if ($link['active']) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Acciones: búsqueda + carrito --}}
        <div class="flex items-center gap-4">
            {{-- Search integrado (desktop) + ícono mobile --}}
            <x-search />

            {{-- Carrito --}}
            <button
                class="text-secondary hover:text-primary transition-colors duration-300 active:opacity-70"
                aria-label="Ver carrito"
            >
                <span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
            </button>
        </div>

    </div>
</header>
