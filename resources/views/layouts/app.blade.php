<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') {{ config('app.name', 'In-TrackFin') }}</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/png">

    <!-- Preloads -->
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        as="style" />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        as="style" />

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

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
                        "primary-fixed-dim": "#adc6ff",
                        "on-primary-fixed": "#001a41",
                        "secondary": "#006e28",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#6ffb85",
                        "on-secondary-container": "#00732a",
                        "secondary-fixed": "#72fe88",
                        "tertiary": "#9e3d00",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#c64f00",
                        "tertiary-fixed": "#ffdbcc",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "background": "#fcf8fb",
                        "on-background": "#1b1b1d",
                        "surface": "#fcf8fb",
                        "on-surface": "#1b1b1d",
                        "on-surface-variant": "#414755",
                        "surface-container": "#f0edef",
                        "surface-container-low": "#f6f3f5",
                        "surface-container-high": "#eae7ea",
                        "surface-container-lowest": "#ffffff",
                        "surface-dim": "#dcd9dc",
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
                        display: ["Inter"],
                    }
                }
            }
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-background text-on-surface font-sans min-h-screen antialiased selection:bg-primary-container selection:text-on-primary-container overflow-x-hidden relative">

    <!-- Global Loader Overlay (Inventera Transition) -->
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

    <div class="flex min-h-screen w-full relative">
        <!-- Sidebar Backdrop (Mobile) -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden lg:hidden"
            onclick="toggleSidebar()"></div>

        <!-- Sidebar (Inventera Style Liquid Glass) -->
        <aside id="sidebar"
            class="fixed top-4 bottom-4 left-4 z-50 w-[270px] liquid-glass rounded-3xl p-5 flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-[320px] lg:translate-x-0">
            <!-- Brand -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3.5 px-2 pt-1">
                    <div
                        class="w-11 h-11 rounded-2xl bg-white/90 backdrop-blur-sm p-1.5 flex items-center justify-center shadow-md shadow-primary/10 border border-white/80 ring-1 ring-black/5 flex-shrink-0">
                        <img src="{{ asset('images/Logo.png') }}" alt="In-TrackFin Logo"
                            class="w-full h-full object-contain">
                    </div>
                    <div class="min-w-0">
                        <h1 class="font-bold text-lg text-on-surface leading-tight tracking-tight">In-TrackFin</h1>
                        <p class="text-[11px] font-medium text-on-surface-variant truncate">Indah Logistik Cianjur</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1.5 overflow-y-auto max-h-[calc(100vh-280px)] pr-1">
                    <p class="px-3 pt-2 pb-1 text-[11px] font-bold tracking-wider uppercase text-on-surface-variant/70">
                        Menu Utama</p>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-2xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-on-surface-variant hover:bg-white/60 hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]"
                            style="{{ request()->routeIs('dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('resi.index') }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-2xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('resi.*') ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-on-surface-variant hover:bg-white/60 hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]"
                            style="{{ request()->routeIs('resi.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">inventory_2</span>
                        <span>Tracking Resi</span>
                    </a>

                    @if(Auth::user()->canManageFinance())
                        <p class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider uppercase text-on-surface-variant/70">
                            Keuangan</p>

                        <a href="{{ route('expenses.index') }}"
                            class="flex items-center space-x-3 px-3.5 py-2.5 rounded-2xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('expenses.*') ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-on-surface-variant hover:bg-white/60 hover:text-on-surface' }}">
                            <span class="material-symbols-outlined text-[20px]"
                                style="{{ request()->routeIs('expenses.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">payments</span>
                            <span>Pengeluaran</span>
                        </a>

                        <a href="{{ route('incomes.index') }}"
                            class="flex items-center space-x-3 px-3.5 py-2.5 rounded-2xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('incomes.*') ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-on-surface-variant hover:bg-white/60 hover:text-on-surface' }}">
                            <span class="material-symbols-outlined text-[20px]"
                                style="{{ request()->routeIs('incomes.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">account_balance_wallet</span>
                            <span>Pemasukan</span>
                        </a>

                        <p class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider uppercase text-on-surface-variant/70">
                            Pelaporan</p>

                        <a href="{{ route('reports.index') }}"
                            class="flex items-center space-x-3 px-3.5 py-2.5 rounded-2xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-on-surface-variant hover:bg-white/60 hover:text-on-surface' }}">
                            <span class="material-symbols-outlined text-[20px]"
                                style="{{ request()->routeIs('reports.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">assessment</span>
                            <span>Laporan Laba Rugi</span>
                        </a>
                    @endif

                    @if(Auth::user()->isKepala())
                        <p class="px-3 pt-4 pb-1 text-[11px] font-bold tracking-wider uppercase text-on-surface-variant/70">
                            Administrasi</p>

                        <a href="{{ route('users.index') }}"
                            class="flex items-center space-x-3 px-3.5 py-2.5 rounded-2xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-on-surface-variant hover:bg-white/60 hover:text-on-surface' }}">
                            <span class="material-symbols-outlined text-[20px]"
                                style="{{ request()->routeIs('users.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">manage_accounts</span>
                            <span>Kelola Akun</span>
                        </a>
                    @endif
                </nav>
            </div>

            <!-- User Footer Card -->
            <div class="pt-3 border-t border-black/5 mt-3">
                <div
                    class="p-2.5 rounded-2xl bg-white/40 border border-white/60 flex items-center justify-between gap-3 shadow-sm">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div
                            class="w-9 h-9 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-sm flex-shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-on-surface truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-medium text-on-surface-variant truncate uppercase">
                                {{ Auth::user()->role_label }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="btn-icon w-8 h-8 hover:text-error hover:bg-error/10 transition"
                            title="Logout">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 min-w-0 lg:ml-[300px] flex flex-col p-4 sm:p-6 lg:p-8">
            <!-- Topbar (Inventera Style) -->
            @php
                $hour = (int) now()->format('H');
                $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
            @endphp
            <header class="flex items-center justify-between gap-4 mb-5 relative z-30">
                <!-- Mobile Toggle & Title -->
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden btn-icon" title="Menu">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div>
                        <p class="text-x font-semibold text-on-surface-variant">{{ $greeting }},
                            {{ Auth::user()->name }}
                        </p>
                        <h2 class="text-xl sm:text-5xl font-bold text-on-surface tracking-tight">
                            @yield('page-title', 'Overview')
                        </h2>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Date Chip -->
                    <div
                        class="hidden md:flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-white/40 backdrop-blur-md border border-white/60 text-xs font-semibold text-on-surface-variant shadow-sm">
                        <span class="material-symbols-outlined text-[16px] text-primary">calendar_today</span>
                        <span>{{ now()->translatedFormat('d F Y') }}</span>
                    </div>

                    <!-- Search Quick Dropdown -->
                    <x-search-dropdown />

                    <!-- Notification Dropdown -->
                    <x-notif-dropdown />

                    @if(Auth::user()->canManageResi())
                        <a href="{{ route('resi.create') }}" class="btn btn-primary btn-sm">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            <span>Resi Baru</span>
                        </a>
                    @endif
                </div>
            </header>

            <!-- Main Page Content with Slide-Up Transition -->
            <main class="slide-up-content flex-1">
                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="alert alert-success" id="flash-success">
                        <span class="material-symbols-outlined text-xl">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error" id="flash-error">
                        <span class="material-symbols-outlined text-xl">error</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </main>

            <footer class="mt-12 text-center text-xs text-on-surface-variant/70 pb-6">
                &copy; {{ date('Y') }} In-TrackFin &bull; Indah Logistik Cabang Cianjur
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar.classList.contains('-translate-x-[320px]')) {
                sidebar.classList.remove('-translate-x-[320px]');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-[320px]');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            }
        }

        // Auto-dismiss flash messages
        setTimeout(() => {
            document.querySelectorAll('[id^="flash-"]').forEach(el => {
                el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-6px)';
                setTimeout(() => el.remove(), 300);
            });
        }, 4000);

        // Page Transition Logic (Inventera Style)
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
    @stack('scripts')
</body>

</html>