<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'In-TrackFin') }} Sistem Keuangan & Logistik</title>
    <meta name="description" content="In-TrackFin: Sistem manajemen keuangan dan logistik internal Indah Logistik Cabang Cianjur. Kelola resi, pemasukan, pengeluaran, dan laporan laba rugi secara efisien.">

    <!-- Preloads -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" as="style" />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" as="style" />

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
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
                        "secondary": "#006e28",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#6ffb85",
                        "secondary-fixed": "#72fe88",
                        "tertiary": "#9e3d00",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#c64f00",
                        "tertiary-fixed": "#ffdbcc",
                        "tertiary-fixed-dim": "#ffb595",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "background": "#fcf8fb",
                        "on-background": "#1b1b1d",
                        "surface": "#fcf8fb",
                        "on-surface": "#1b1b1d",
                        "on-surface-variant": "#414755",
                        "surface-container": "#f0edef",
                        "surface-container-low": "#f6f3f5",
                        "surface-container-high": "#eae7ea",
                        "surface-container-highest": "#e4e2e4",
                        "surface-container-lowest": "#ffffff",
                        "surface-dim": "#dcd9dc",
                        "surface-variant": "#e4e2e4",
                        "outline": "#717786",
                        "outline-variant": "#c1c6d7",
                        "inverse-surface": "#303032",
                        "inverse-on-surface": "#f3f0f2",
                        "inverse-primary": "#adc6ff",
                    },
                    borderRadius: {
                        DEFAULT: "1rem",
                        lg: "2rem",
                        xl: "3rem",
                        full: "9999px",
                    },
                    spacing: {
                        "container-max": "1200px",
                        gutter: "24px",
                        "margin-desktop": "48px",
                        unit: "4px",
                        "margin-mobile": "20px",
                    },
                    fontFamily: {
                        sans: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                    },
                    fontSize: {
                        "label-md": ["14px", { lineHeight: "1.4", letterSpacing: "0.01em", fontWeight: "600" }],
                        "label-sm": ["12px", { lineHeight: "1.4", letterSpacing: "0.02em", fontWeight: "600" }],
                        "body-md": ["16px", { lineHeight: "1.5", letterSpacing: "0", fontWeight: "500" }],
                        "body-lg": ["18px", { lineHeight: "1.5", letterSpacing: "-0.005em", fontWeight: "500" }],
                        "headline-md": ["24px", { lineHeight: "1.3", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "headline-lg": ["32px", { lineHeight: "1.2", letterSpacing: "-0.015em", fontWeight: "600" }],
                        "headline-lg-mobile": ["28px", { lineHeight: "1.2", letterSpacing: "-0.01em", fontWeight: "600" }],
                        display: ["48px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "600" }],
                    },
                },
            },
        };
    </script>
    <style>
        /* Page Transition */
        body > *:not(#global-loader) {
            opacity: 0;
            transition: opacity 0.8s ease-out, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            transform: translateY(30px) scale(0.95);
        }
        body.page-loaded > *:not(#global-loader) {
            opacity: 1;
            transform: none;
        }
        body.page-leaving > *:not(#global-loader) {
            opacity: 0;
            transform: translateY(-20px) scale(0.98);
        }
        /* Global Loader */
        #global-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background-color: #fcf8fb;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.4s ease-out, visibility 0.4s ease-out;
        }
        body.page-loaded #global-loader {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        body.page-leaving #global-loader {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease-in;
        }
        /* Staggered Animation for Feature Cards */
        .feature-card {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        body.page-loaded .feature-card {
            opacity: 1;
            transform: none;
        }
        body.page-loaded .feature-card:nth-child(1) { transition-delay: 0.15s; }
        body.page-loaded .feature-card:nth-child(2) { transition-delay: 0.25s; }
        body.page-loaded .feature-card:nth-child(3) { transition-delay: 0.35s; }
        body.page-loaded .feature-card:nth-child(4) { transition-delay: 0.45s; }

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .float-anim { animation: float 6s ease-in-out infinite; }
        .float-anim-delay { animation: float 6s ease-in-out 2s infinite; }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #0058bc, #0070eb, #006e28);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Glass Card Hover */
        .glass-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05), 0 20px 40px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            box-shadow: 0 8px 24px rgba(0, 88, 188, 0.1), 0 24px 48px rgba(0, 0, 0, 0.08);
            transform: translateY(-4px);
            border-color: rgba(0, 88, 188, 0.2);
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-background min-h-screen flex flex-col relative overflow-x-hidden font-sans">

    <!-- Global Loader Overlay -->
    <div id="global-loader">
        <div class="flex flex-col items-center justify-center space-y-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/90 backdrop-blur-md p-1.5 flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/Logo.png') }}" alt="In-TrackFin Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-headline-md font-bold text-on-surface tracking-tight">In-TrackFin</span>
            </div>
            <div class="w-10 h-10 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
        </div>
    </div>

    <!-- Abstract Background Elements for Depth -->
    <div class="absolute top-[-10%] left-[-5%] w-[40vw] h-[40vw] rounded-full bg-primary-fixed/30 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[50vw] h-[50vw] rounded-full bg-tertiary-fixed-dim/20 blur-[150px] pointer-events-none"></div>
    <div class="absolute top-[30%] right-[-10%] w-[30vw] h-[30vw] rounded-full bg-secondary-fixed/15 blur-[100px] pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="w-full px-margin-mobile md:px-margin-desktop py-5 z-20 relative">
        <div class="max-w-[1200px] mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/90 backdrop-blur-md p-1 flex items-center justify-center shadow-[0_4px_12px_rgba(0,88,188,0.15)] border border-white/60">
                    <img src="{{ asset('images/Logo.png') }}" alt="In-TrackFin Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-xl font-bold text-on-surface tracking-tight">In-TrackFin</span>
            </div>
            <!-- Auth Links -->
            @if (Route::has('login'))
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 bg-primary text-on-primary font-semibold text-sm py-2.5 px-6 rounded-full shadow-[0_4px_12px_rgba(0,88,188,0.2)] hover:bg-primary-container hover:shadow-[0_6px_16px_rgba(0,88,188,0.3)] transition-all active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[18px]">dashboard</span>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-1.5 text-on-surface-variant font-semibold text-sm py-2.5 px-5 rounded-full border border-outline-variant hover:border-primary hover:text-primary transition-all">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 bg-primary text-on-primary font-semibold text-sm py-2.5 px-6 rounded-full shadow-[0_4px_12px_rgba(0,88,188,0.2)] hover:bg-primary-container hover:shadow-[0_6px_16px_rgba(0,88,188,0.3)] transition-all active:scale-[0.98]">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="w-full px-margin-mobile md:px-margin-desktop pt-12 md:pt-20 pb-16 md:pb-28 z-10 relative">
        <div class="max-w-[1200px] mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <!-- Hero Text -->
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-primary-fixed/50 backdrop-blur-sm text-primary font-semibold text-sm py-2 px-4 rounded-full mb-6 border border-primary/10">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    Indah Logistik Cabang Cianjur
                </div>
                <h1 class="text-headline-lg-mobile md:text-display font-extrabold text-on-surface mb-6 tracking-tight leading-tight">
                    Kelola Keuangan & Logistik
                    <span class="gradient-text"> Lebih Cerdas</span>
                </h1>
                <p class="text-body-lg text-on-surface-variant mb-8 max-w-lg mx-auto lg:mx-0">
                    Sistem terintegrasi untuk manajemen resi, pemasukan, pengeluaran, dan laporan laba rugi. Semua dalam satu platform yang efisien.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary font-semibold text-body-md py-4 px-8 rounded-full shadow-[0_4px_12px_rgba(0,88,188,0.2)] hover:bg-primary-container hover:shadow-[0_6px_16px_rgba(0,88,188,0.3)] transition-all active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[20px]">dashboard</span>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary font-semibold text-body-md py-4 px-8 rounded-full shadow-[0_4px_12px_rgba(0,88,188,0.2)] hover:bg-primary-container hover:shadow-[0_6px_16px_rgba(0,88,188,0.3)] transition-all active:scale-[0.98]">
                            <span class="material-symbols-outlined text-[20px]">login</span>
                            Masuk ke Sistem
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center gap-2 bg-surface-container-lowest/50 backdrop-blur-sm text-on-surface font-semibold text-body-md py-4 px-8 rounded-full border border-outline-variant hover:border-primary hover:text-primary transition-all">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                                Buat Akun
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Hero Visual - Abstract Dashboard Preview -->
            <div class="flex-1 max-w-lg w-full relative">
                <div class="float-anim">
                    <div class="glass-card rounded-2xl p-6 md:p-8">
                        <!-- Mini Dashboard Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-[20px]">analytics</span>
                                </div>
                                <div>
                                    <p class="text-label-md text-on-surface">Dashboard</p>
                                    <p class="text-label-sm text-on-surface-variant">Ringkasan Hari Ini</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-secondary"></div>
                                <span class="text-label-sm text-secondary">Live</span>
                            </div>
                        </div>

                        <!-- Mini Stats Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="bg-primary-fixed/30 rounded-xl p-4">
                                <span class="material-symbols-outlined text-primary text-[20px] mb-1">receipt_long</span>
                                <p class="text-xl font-bold text-on-surface">1,248</p>
                                <p class="text-label-sm text-on-surface-variant">Total Resi</p>
                            </div>
                            <div class="bg-secondary-fixed/20 rounded-xl p-4">
                                <span class="material-symbols-outlined text-secondary text-[20px] mb-1">trending_up</span>
                                <p class="text-xl font-bold text-on-surface">Rp 42.5M</p>
                                <p class="text-label-sm text-on-surface-variant">Pemasukan</p>
                            </div>
                            <div class="bg-tertiary-fixed/20 rounded-xl p-4">
                                <span class="material-symbols-outlined text-tertiary text-[20px] mb-1">trending_down</span>
                                <p class="text-xl font-bold text-on-surface">Rp 18.2M</p>
                                <p class="text-label-sm text-on-surface-variant">Pengeluaran</p>
                            </div>
                            <div class="bg-surface-container-high/60 rounded-xl p-4">
                                <span class="material-symbols-outlined text-primary text-[20px] mb-1">account_balance</span>
                                <p class="text-xl font-bold text-on-surface">Rp 24.3M</p>
                                <p class="text-label-sm text-on-surface-variant">Laba Bersih</p>
                            </div>
                        </div>

                        <!-- Mini Chart Placeholder -->
                        <div class="bg-surface-container-low/50 rounded-xl p-4 flex items-end gap-1.5 h-20">
                            <div class="flex-1 bg-primary/20 rounded-t" style="height: 40%"></div>
                            <div class="flex-1 bg-primary/30 rounded-t" style="height: 55%"></div>
                            <div class="flex-1 bg-primary/40 rounded-t" style="height: 35%"></div>
                            <div class="flex-1 bg-primary/50 rounded-t" style="height: 70%"></div>
                            <div class="flex-1 bg-primary/60 rounded-t" style="height: 50%"></div>
                            <div class="flex-1 bg-primary/70 rounded-t" style="height: 85%"></div>
                            <div class="flex-1 bg-primary rounded-t" style="height: 95%"></div>
                        </div>
                    </div>
                </div>

                <!-- Floating Badge -->
                <div class="absolute -bottom-4 -left-4 float-anim-delay">
                    <div class="glass-card rounded-xl px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary text-[18px]">check_circle</span>
                        </div>
                        <div>
                            <p class="text-label-md text-on-surface">Resi Terkirim</p>
                            <p class="text-label-sm text-on-surface-variant">+24 hari ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="w-full px-margin-mobile md:px-margin-desktop py-16 md:py-24 z-10 relative">
        <div class="max-w-[1200px] mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12 md:mb-16">
                <div class="inline-flex items-center gap-2 bg-primary-fixed/40 backdrop-blur-sm text-primary font-semibold text-sm py-2 px-4 rounded-full mb-5 border border-primary/10">
                    <span class="material-symbols-outlined text-[16px]">apps</span>
                    Fitur Utama
                </div>
                <h2 class="text-headline-lg-mobile md:text-headline-lg font-extrabold text-on-surface mb-4 tracking-tight">
                    Semua yang Anda Butuhkan
                </h2>
                <p class="text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                    Fitur lengkap untuk mengelola seluruh operasional keuangan dan logistik cabang.
                </p>
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Feature 1: Kelola Resi -->
                <div class="feature-card glass-card rounded-2xl p-6 group cursor-default">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center mb-5 group-hover:bg-primary/20 transition-colors">
                        <span class="material-symbols-outlined text-primary text-[26px]">receipt_long</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-2">Kelola Resi</h3>
                    <p class="text-body-md text-on-surface-variant leading-relaxed">
                        Tambah, edit, hapus, dan tracking status resi pengiriman dengan mudah dan cepat.
                    </p>
                </div>

                <!-- Feature 2: Pemasukan & Pengeluaran -->
                <div class="feature-card glass-card rounded-2xl p-6 group cursor-default">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center mb-5 group-hover:bg-secondary/20 transition-colors">
                        <span class="material-symbols-outlined text-secondary text-[26px]">swap_vert</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-2">Pemasukan & Pengeluaran</h3>
                    <p class="text-body-md text-on-surface-variant leading-relaxed">
                        Catat dan pantau seluruh arus keuangan masuk dan keluar secara real-time.
                    </p>
                </div>

                <!-- Feature 3: Laporan Laba Rugi -->
                <div class="feature-card glass-card rounded-2xl p-6 group cursor-default">
                    <div class="w-12 h-12 rounded-xl bg-tertiary/10 flex items-center justify-center mb-5 group-hover:bg-tertiary/20 transition-colors">
                        <span class="material-symbols-outlined text-tertiary text-[26px]">bar_chart</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-2">Laporan Laba Rugi</h3>
                    <p class="text-body-md text-on-surface-variant leading-relaxed">
                        Generate laporan keuangan lengkap dengan filter periode dan export PDF.
                    </p>
                </div>

                <!-- Feature 4: Manajemen Akun -->
                <div class="feature-card glass-card rounded-2xl p-6 group cursor-default">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center mb-5 group-hover:bg-primary/20 transition-colors">
                        <span class="material-symbols-outlined text-primary text-[26px]">group</span>
                    </div>
                    <h3 class="text-lg font-bold text-on-surface mb-2">Manajemen Akun</h3>
                    <p class="text-body-md text-on-surface-variant leading-relaxed">
                        Kelola pengguna dengan role Kepala Cabang, Admin Accounting, dan Admin Ekspedisi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats / Trust Section -->
    <section class="w-full px-margin-mobile md:px-margin-desktop py-12 md:py-16 z-10 relative">
        <div class="max-w-[1200px] mx-auto">
            <div class="glass-card rounded-2xl p-8 md:p-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-primary text-[28px]">local_shipping</span>
                        </div>
                        <p class="text-2xl md:text-3xl font-bold text-on-surface">1,000+</p>
                        <p class="text-body-md text-on-surface-variant mt-1">Resi Diproses</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-secondary text-[28px]">speed</span>
                        </div>
                        <p class="text-2xl md:text-3xl font-bold text-on-surface">Real-time</p>
                        <p class="text-body-md text-on-surface-variant mt-1">Tracking Status</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-tertiary text-[28px]">shield</span>
                        </div>
                        <p class="text-2xl md:text-3xl font-bold text-on-surface">Aman</p>
                        <p class="text-body-md text-on-surface-variant mt-1">Data Terproteksi</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-primary text-[28px]">download</span>
                        </div>
                        <p class="text-2xl md:text-3xl font-bold text-on-surface">Export</p>
                        <p class="text-body-md text-on-surface-variant mt-1">PDF & Excel</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="w-full px-margin-mobile md:px-margin-desktop py-16 md:py-24 z-10 relative">
        <div class="max-w-[800px] mx-auto text-center">
            <h2 class="text-headline-lg-mobile md:text-headline-lg font-extrabold text-on-surface mb-4 tracking-tight">
                Siap Mengelola Keuangan Lebih Efisien?
            </h2>
            <p class="text-body-lg text-on-surface-variant mb-8 max-w-xl mx-auto">
                Mulai gunakan In-TrackFin sekarang untuk pengalaman manajemen keuangan dan logistik yang lebih baik.
            </p>
            @guest
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary font-semibold text-body-md py-4 px-8 rounded-full shadow-[0_4px_12px_rgba(0,88,188,0.2)] hover:bg-primary-container hover:shadow-[0_6px_16px_rgba(0,88,188,0.3)] transition-all active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[20px]">login</span>
                        Masuk Sekarang
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-2 bg-surface-container-lowest/50 backdrop-blur-sm text-on-surface font-semibold text-body-md py-4 px-8 rounded-full border border-outline-variant hover:border-primary hover:text-primary transition-all">
                            <span class="material-symbols-outlined text-[20px]">person_add</span>
                            Daftar Akun Baru
                        </a>
                    @endif
                </div>
            @endguest
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary font-semibold text-body-md py-4 px-8 rounded-full shadow-[0_4px_12px_rgba(0,88,188,0.2)] hover:bg-primary-container hover:shadow-[0_6px_16px_rgba(0,88,188,0.3)] transition-all active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    Buka Dashboard
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full px-margin-mobile md:px-margin-desktop py-8 z-10 relative mt-auto">
        <div class="max-w-[1200px] mx-auto flex flex-col items-center justify-center gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/90 p-1 flex items-center justify-center shadow-sm border border-white/60">
                    <img src="{{ asset('images/Logo.png') }}" alt="In-TrackFin Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-label-md text-on-surface font-bold">In-TrackFin</span>
            </div>
            <p class="text-label-sm text-on-surface-variant text-center">
                &copy; {{ date('Y') }} Indah Logistik Cabang Cianjur. All rights reserved.
            </p>
            <div class="flex gap-4">
                <a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <span class="text-outline-variant">·</span>
                <a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Contact Support</a>
            </div>
        </div>
    </footer>

    <!-- Page Transition Script -->
    <script>
        let isPageLoaded = false;
        window.addEventListener("load", function () {
            isPageLoaded = true;
            setTimeout(() => {
                document.body.classList.add("page-loaded");
                document.body.classList.remove("page-leaving");
            }, 150);
        });

        window.addEventListener("pageshow", function (e) {
            if (e.persisted || isPageLoaded) {
                document.body.classList.add("page-loaded");
                document.body.classList.remove("page-leaving");
            }
        });

        window.addEventListener("beforeunload", function () {
            document.body.classList.remove("page-loaded");
            document.body.classList.add("page-leaving");
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
                        }, 500);
                    }
                });
            });
        });
    </script>
</body>
</html>
