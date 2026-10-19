<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login {{ config('app.name', 'In-TrackFin') }}</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/png">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Tailwind CDN + Config (Inventera Design System) -->
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
                        "on-primary-container": "#fefcff",
                        "primary-fixed": "#d8e2ff",
                        "secondary": "#006e28",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#6ffb85",
                        "tertiary": "#9e3d00",
                        "tertiary-fixed": "#ffdbcc",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "background": "#fcf8fb",
                        "on-background": "#1b1b1d",
                        "surface": "#fcf8fb",
                        "on-surface": "#1b1b1d",
                        "on-surface-variant": "#414755",
                        "surface-container": "#f0edef",
                        "surface-container-high": "#eae7ea",
                        "surface-container-lowest": "#ffffff",
                        "outline": "#717786",
                        "outline-variant": "#c1c6d7",
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                    fontFamily: {
                        sans: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                    }
                }
            }
        };
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-background text-on-surface font-sans min-h-screen flex flex-col justify-center items-center px-4 relative overflow-hidden antialiased">

    <!-- Global Loader Overlay -->
    <div id="global-loader">
        <div class="flex flex-col items-center justify-center space-y-6">
            <div
                class="w-20 h-20 rounded-3xl bg-white/90 backdrop-blur-md p-3.5 flex items-center justify-center shadow-xl shadow-primary/15 border border-white/80 animate-pulse">
                <img src="{{ asset('images/Logo.png') }}" alt="In-TrackFin Logo" class="w-full h-full object-contain">
            </div>
            <div class="w-10 h-10 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
            <p class="font-bold text-sm tracking-widest text-on-surface">In-TrackFin</p>
        </div>
    </div>

    <!-- Soft Mesh Gradient Background Blobs -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-5%] w-[55vw] h-[55vw] mesh-blob-1 rounded-full opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[50vw] h-[50vw] mesh-blob-2 rounded-full opacity-50"></div>
        <div class="absolute top-[35%] left-[35%] w-[35vw] h-[35vw] mesh-blob-3 rounded-full"></div>
    </div>

    <!-- Main Glass Login Card -->
    <div class="w-full max-w-[440px] z-10 slide-up-content">
        <div class="liquid-glass rounded-3xl p-8 sm:p-10 relative overflow-hidden">
            <!-- Branding -->
            <div class="flex flex-col items-center mb-8 text-center">
                <div
                    class="w-20 h-20 rounded-3xl bg-white/90 backdrop-blur-md p-3.5 flex items-center justify-center mb-4 shadow-xl shadow-primary/10 border border-white/80 ring-1 ring-black/5">
                    <img src="{{ asset('images/Logo.png') }}" alt="In-TrackFin Logo"
                        class="w-full h-full object-contain filter drop-shadow-sm">
                </div>
                <h1 class="text-2xl font-black text-on-surface tracking-tight">In-TrackFin</h1>
                <p class="text-xs font-semibold text-on-surface-variant mt-1">Indah Logistik &bull; Cabang Cianjur</p>
            </div>

            <!-- Flash Error -->
            @if($errors->any())
                <div class="alert alert-error mb-6">
                    <span class="material-symbols-outlined text-lg flex-shrink-0">error</span>
                    <span class="text-xs">{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="space-y-1.5">
                    <label class="form-label text-xs tracking-wide text-on-surface-variant font-semibold"
                        for="email">Alamat Email</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px] pointer-events-none select-none">mail</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="username" placeholder="nama@intrack.fin"
                            class="form-input !rounded-full pr-4 py-3 bg-white/50 border border-outline-variant/80 focus:border-primary focus:bg-white/80 focus:ring-2 focus:ring-primary/20 text-sm font-medium transition-all"
                            style="padding-left: 2.65rem;" />
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <label class="form-label text-xs tracking-wide text-on-surface-variant font-semibold"
                        for="password">Kata Sandi</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px] pointer-events-none select-none">lock</span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="form-input !rounded-full pr-4 py-3 bg-white/50 border border-outline-variant/80 focus:border-primary focus:bg-white/80 focus:ring-2 focus:ring-primary/20 text-sm font-medium transition-all"
                            style="padding-left: 2.65rem;" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded text-primary focus:ring-primary/20 border-outline-variant">
                        <span class="text-xs font-medium text-on-surface-variant">Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="btn btn-primary w-full py-3.5 text-sm font-bold shadow-lg shadow-primary/25 mt-2">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    <span>Masuk ke Sistem</span>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-on-surface-variant/70 mt-6 font-medium">
            &copy; {{ date('Y') }} In-TrackFin &bull; PT Indah Logistik
        </p>
    </div>

    <!-- Page Transition Logic -->
    <script>
        let isPageLoaded = false;
        window.addEventListener("load", function () {
            isPageLoaded = true;
            setTimeout(() => {
                document.body.classList.add("page-loaded");
                document.body.classList.remove("page-leaving");
            }, 120);
        });

        window.addEventListener("pageshow", function (e) {
            if (e.persisted || isPageLoaded) {
                document.body.classList.add("page-loaded");
                document.body.classList.remove("page-leaving");
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', e => {
                    if (
                        link.hostname === window.location.hostname &&
                        !link.target &&
                        !link.hasAttribute('download') &&
                        !link.hasAttribute('onclick') &&
                        link.href &&
                        !link.href.includes('#')
                    ) {
                        e.preventDefault();
                        document.body.classList.remove("page-loaded");
                        document.body.classList.add("page-leaving");
                        setTimeout(() => {
                            window.location = link.href;
                        }, 400);
                    }
                });
            });
        });
    </script>
</body>

</html>