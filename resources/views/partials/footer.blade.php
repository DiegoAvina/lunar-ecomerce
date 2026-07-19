{{--
    Partial: Footer
    Incluir con: @include('partials.footer')

    $footerLinks (opcional) → array de enlaces del footer
--}}

@php
    $footerLinks = $footerLinks ?? [
        ['label' => 'Política de Privacidad', 'url' => '#'],
        ['label' => 'Términos de Servicio',   'url' => '#'],
        ['label' => 'Sostenibilidad',          'url' => '#'],
        ['label' => 'Carreras',                'url' => '#'],
    ];

    $year = date('Y');
@endphp

<footer class="bg-white dark:bg-gray-950 w-full border-t border-gray-100 dark:border-gray-900 shadow-none">
    <div class="max-w-screen-2xl mx-auto px-8 py-16
                flex flex-col md:flex-row justify-between items-center gap-8
                font-inter text-sm uppercase tracking-widest antialiased">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-lg font-bold text-primary dark:text-blue-500">
            Optidigital
        </a>

        {{-- Links --}}
        <nav class="flex flex-wrap justify-center gap-8" aria-label="Footer">
            @foreach ($footerLinks as $link)
                <a href="{{ $link['url'] }}"
                   class="text-gray-400 dark:text-gray-600 hover:text-primary transition-colors">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Copyright --}}
        <p class="text-gray-400 dark:text-gray-600">
            &copy; {{ $year }} Optidigital. Ingeniería de Precisión.
        </p>

    </div>
</footer>
