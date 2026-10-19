<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'In-TrackFin') }}</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/png">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0058bc",
                        "on-primary": "#ffffff",
                        "primary-container": "#0070eb",
                        "primary-fixed": "#d8e2ff",
                        "secondary": "#006e28",
                        "error": "#ba1a1a",
                        "background": "#fcf8fb",
                        "surface": "#fcf8fb",
                        "on-surface": "#1b1b1d",
                        "on-surface-variant": "#414755",
                        "outline-variant": "#c1c6d7",
                    },
                    borderRadius: {
                        DEFAULT: "1rem",
                        lg: "2rem",
                        xl: "3rem",
                        full: "9999px"
                    }
                }
            }
        };
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface font-sans min-h-screen flex flex-col justify-center items-center px-4 relative overflow-hidden antialiased">
    <!-- Mesh blobs -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-5%] w-[55vw] h-[55vw] mesh-blob-1 rounded-full opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[50vw] h-[50vw] mesh-blob-2 rounded-full opacity-50"></div>
    </div>

    <div class="w-full max-w-[440px] z-10">
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-3xl bg-white/90 backdrop-blur-md p-2.5 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-primary/10 border border-white/80 ring-1 ring-black/5">
                <img src="{{ asset('images/Logo.png') }}" alt="In-TrackFin Logo" class="w-full h-full object-contain filter drop-shadow-sm">
            </div>
            <h1 class="text-xl font-bold text-on-surface">In-TrackFin</h1>
        </div>

        <div class="liquid-glass rounded-3xl p-8 relative overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
