<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Optidigital | Innovando tu Mundo')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed": "#1a1c1c",
                        "secondary-fixed-dim": "#c6c6c6",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed-variant": "#44474a",
                        "outline": "#737784",
                        "inverse-on-surface": "#f3f0ef",
                        "secondary-container": "#e0dfdf",
                        "surface-tint": "#2559bd",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#dae2ff",
                        "surface-container-highest": "#e5e2e1",
                        "surface": "#fcf9f8",
                        "on-background": "#1c1b1b",
                        "surface-container": "#f0eded",
                        "on-tertiary-container": "#bcbfc2",
                        "surface-container-low": "#f6f3f2",
                        "error-container": "#ffdad6",
                        "on-surface": "#1c1b1b",
                        "surface-bright": "#fcf9f8",
                        "secondary-fixed": "#e3e2e2",
                        "primary-fixed-dim": "#b1c5ff",
                        "on-error": "#ffffff",
                        "secondary": "#5d5e5f",
                        "primary": "#00327d",
                        "on-error-container": "#93000a",
                        "inverse-surface": "#313030",
                        "on-surface-variant": "#434653",
                        "on-secondary-container": "#626363",
                        "primary-container": "#0047ab",
                        "inverse-primary": "#b1c5ff",
                        "on-primary-fixed": "#001946",
                        "on-secondary": "#ffffff",
                        "tertiary": "#34373a",
                        "outline-variant": "#c3c6d5",
                        "error": "#ba1a1a",
                        "tertiary-fixed": "#e0e3e6",
                        "tertiary-container": "#4b4e50",
                        "on-primary-fixed-variant": "#00419e",
                        "tertiary-fixed-dim": "#c4c7ca",
                        "on-secondary-fixed-variant": "#464747",
                        "surface-dim": "#dcd9d9",
                        "on-primary-container": "#a5bdff",
                        "surface-variant": "#e5e2e1",
                        "on-tertiary-fixed": "#191c1e",
                        "background": "#fcf9f8",
                        "on-tertiary": "#ffffff",
                        "surface-container-high": "#eae7e7"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "unit": "4px",
                        "margin-x": "64px",
                        "container-max": "1440px",
                        "section-gap": "128px",
                        "gutter": "32px"
                    },
                    "fontFamily": {
                        "headline-sm": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "label-md": ["Inter"],
                        "body-md": ["Inter"],
                        "display-lg": ["Inter"],
                        "display-xl": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "headline-sm": ["24px", {"lineHeight": "1.4", "letterSpacing": "0", "fontWeight": "400"}],
                        "headline-md": ["32px", {"lineHeight": "1.3", "letterSpacing": "-0.01em", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "1", "letterSpacing": "0.02em", "fontWeight": "400"}],
                        "label-md": ["14px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "letterSpacing": "0", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "300"}],
                        "display-xl": ["72px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "300"}],
                        "body-lg": ["18px", {"lineHeight": "1.6", "letterSpacing": "0", "fontWeight": "300"}]
                    }
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #fcf9f8;
            color: #1c1b1b;
        }
        .carousel-item {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .carousel-item.active {
            opacity: 1;
            position: relative;
            pointer-events: auto;
        }
    </style>

    @stack('styles')
</head>
<body class="font-body-md antialiased overflow-x-hidden">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Contenido principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Scripts del carousel (solo si la página los necesita) --}}
    @stack('scripts')

</body>
</html>
