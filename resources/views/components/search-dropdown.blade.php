{{-- Search Dropdown - Seragam gaya dengan notif-dropdown (Inventera Frosted Glass) --}}
<div class="relative" id="search-wrapper">

    <!-- Search Button -->
    <button id="search-btn" type="button" onclick="toggleSearch()"
        class="relative w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant transition-all duration-200 hover:text-on-surface hover:bg-white/60 active:scale-95"
        style="background: rgba(255,255,255,0.25); backdrop-filter: blur(80px) saturate(2.2) brightness(1.06); -webkit-backdrop-filter: blur(80px) saturate(2.2) brightness(1.06); border: 1px solid rgba(255,255,255,0.85); box-shadow: 0 4px 16px rgba(0,88,188,0.04), inset 0 1.5px 0 rgba(255,255,255,0.95);"
        aria-label="Cari Cepat" title="Cari Menu & Fitur (ESC)">
        <span id="search-icon" class="material-symbols-outlined text-[20px]">search</span>
    </button>

    <!-- Dropdown Panel (Liquid Frosted Glass Style) -->
    <div id="search-dropdown"
        class="search-dropdown absolute right-0 mt-3 w-[360px] sm:w-[420px] z-50 origin-top-right rounded-[24px]"
        aria-hidden="true">

        <!-- Search Input Bar -->
        <div class="px-4 py-3 border-b border-white/40">
            <div class="flex items-center gap-3 px-3.5 py-2 rounded-full"
                style="background: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.75);">
                <span class="material-symbols-outlined text-[18px] text-on-surface-variant flex-shrink-0">search</span>
                <input id="search-input" type="text" placeholder="Cari menu, resi, keuangan, laporan..."
                    autocomplete="off" oninput="handleSearch(this.value)"
                    class="flex-1 bg-transparent border-none outline-none ring-0 shadow-none focus:ring-0 focus:outline-none focus:border-none focus:shadow-none text-xs font-semibold text-on-surface placeholder:text-on-surface-variant/50"
                    style="box-shadow: none !important; outline: none !important; border: none !important; padding: 0 !important;" />
                <button onclick="clearSearch()" id="search-clear" type="button"
                    class="hidden text-on-surface-variant hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
                <kbd
                    class="hidden md:inline-flex text-on-surface-variant/50 px-1.5 py-0.5 rounded border border-white/50 text-[10px] font-mono">ESC</kbd>
            </div>
        </div>

        <!-- Quick Links (Default State) -->
        <div id="search-quick" class="py-2">
            <p class="px-5 pt-2 pb-1 text-[11px] font-bold text-on-surface-variant/70 uppercase tracking-widest">Akses
                Cepat Menu</p>

            <a href="{{ route('dashboard') }}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                    style="background: rgba(0,88,188,0.1);">
                    <span class="material-symbols-outlined text-[16px] text-primary"
                        style="font-variation-settings:'FILL' 1;">dashboard</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface">Dashboard Overview</p>
                    <p class="text-[11px] text-on-surface-variant/70">Ringkasan operasional & kas cabang</p>
                </div>
                <span
                    class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
            </a>

            <a href="{{ route('resi.index') }}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                    style="background: rgba(0,88,188,0.1);">
                    <span class="material-symbols-outlined text-[16px] text-primary"
                        style="font-variation-settings:'FILL' 1;">inventory_2</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface">Tracking Resi</p>
                    <p class="text-[11px] text-on-surface-variant/70">Daftar paket & status pengiriman</p>
                </div>
                <span
                    class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
            </a>

            @if(Auth::user()->canManageResi())
                <a href="{{ route('resi.create') }}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                        style="background: rgba(0,110,40,0.1);">
                        <span class="material-symbols-outlined text-[16px] text-secondary"
                            style="font-variation-settings:'FILL' 1;">add_box</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-on-surface">Input Resi Baru</p>
                        <p class="text-[11px] text-on-surface-variant/70">Pendaftaran nomor resi pengiriman</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
                </a>
            @endif

            @if(Auth::user()->canManageFinance())
                <a href="{{ route('expenses.index') }}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                        style="background: rgba(186,26,26,0.1);">
                        <span class="material-symbols-outlined text-[16px] text-error"
                            style="font-variation-settings:'FILL' 1;">payments</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-on-surface">Pengeluaran Operasional</p>
                        <p class="text-[11px] text-on-surface-variant/70">BBM armada, operasional & kantor</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
                </a>

                <a href="{{ route('incomes.index') }}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                        style="background: rgba(0,110,40,0.1);">
                        <span class="material-symbols-outlined text-[16px] text-secondary"
                            style="font-variation-settings:'FILL' 1;">account_balance_wallet</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-on-surface">Pemasukan Kas</p>
                        <p class="text-[11px] text-on-surface-variant/70">Tarif resi & penerimaan lainnya</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
                </a>

                <a href="{{ route('reports.index') }}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                        style="background: rgba(158,61,0,0.1);">
                        <span class="material-symbols-outlined text-[16px] text-tertiary"
                            style="font-variation-settings:'FILL' 1;">assessment</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-on-surface">Laporan Laba Rugi</p>
                        <p class="text-[11px] text-on-surface-variant/70">Rekapitulasi keuangan laba kotor & bersih</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
                </a>
            @endif

            @if(Auth::user()->isKepala())
                <a href="{{ route('users.index') }}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                        style="background: rgba(0,88,188,0.1);">
                        <span class="material-symbols-outlined text-[16px] text-primary"
                            style="font-variation-settings:'FILL' 1;">manage_accounts</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-on-surface">Kelola Akun</p>
                        <p class="text-[11px] text-on-surface-variant/70">Manajemen staf & hak akses cabang</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
                </a>
            @endif
        </div>

        <!-- Search Results (Tampil saat user mengetik) -->
        <div id="search-results" class="hidden py-2 max-h-[340px] overflow-y-auto">
            <p class="px-5 pt-2 pb-1 text-[11px] font-bold text-on-surface-variant/70 uppercase tracking-widest">Hasil
                Pencarian</p>
            <div id="search-results-list"></div>
            <div id="search-empty" class="hidden flex flex-col items-center py-8 gap-2">
                <span class="material-symbols-outlined text-[36px] text-on-surface-variant/30">search_off</span>
                <p class="text-xs font-medium text-on-surface-variant/50">Tidak ada menu atau data ditemukan</p>
            </div>
        </div>

        <!-- Footer Hint -->
        <div class="px-5 py-3 flex items-center gap-4 border-t border-white/30 text-on-surface-variant/60 text-[11px]">
            <span class="flex items-center gap-1.5">
                <kbd class="px-1.5 py-0.5 rounded border border-white/40 text-[10px] font-mono">Click</kbd> Pilih
            </span>
            <span class="flex items-center gap-1.5 ml-auto">
                <kbd class="px-1.5 py-0.5 rounded border border-white/40 text-[10px] font-mono">ESC</kbd> Tutup
            </span>
        </div>
    </div>
</div>

<style>
    /* Dropdown Glass Styling - Identik dengan notif-dropdown */
    #search-dropdown {
        background: rgba(246, 248, 255, 0.42);
        backdrop-filter: blur(20px) saturate(2.2) brightness(1.06) contrast(0.96);
        -webkit-backdrop-filter: blur(20px) saturate(2.2) brightness(1.06) contrast(0.96);
        border: 1px solid rgba(255, 255, 255, 0.85);
        box-shadow:
            0 8px 32px rgba(0, 88, 188, 0.08),
            0 30px 60px rgba(0, 0, 0, 0.08),
            inset 0 1.5px 0 rgba(255, 255, 255, 0.95),
            inset 0 -1px 0 rgba(0, 0, 0, 0.04);
        overflow: clip;
    }

    #search-dropdown::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(140deg,
                rgba(255, 255, 255, 0.45) 0%,
                rgba(255, 255, 255, 0.06) 45%,
                rgba(180, 205, 255, 0.08) 75%,
                rgba(255, 255, 255, 0.25) 100%);
        pointer-events: none;
        z-index: 0;
    }

    #search-dropdown>* {
        position: relative;
        z-index: 1;
    }

    /* Dropdown Animations */
    .search-dropdown {
        pointer-events: none;
        opacity: 0;
        transform: scale(0.92) translateY(-8px);
        transform-origin: top right;
        transition:
            opacity 0.28s cubic-bezier(0.32, 0.72, 0, 1),
            transform 0.28s cubic-bezier(0.32, 0.72, 0, 1);
        will-change: transform, opacity;
    }

    .search-dropdown.open {
        pointer-events: auto;
        opacity: 1;
        transform: scale(1) translateY(0);
    }

    /* Result Item Hover & Animation */
    .search-result-item {
        cursor: pointer;
        transition: background 0.18s ease;
        text-decoration: none;
    }

    .search-result-item:hover {
        background: rgba(255, 255, 255, 0.4);
    }

    @keyframes fadeInUpSearchItem {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .search-dropdown.open .search-result-item {
        animation: fadeInUpSearchItem 0.35s cubic-bezier(0.32, 0.72, 0, 1) both;
    }

    .search-dropdown.open .search-result-item:nth-of-type(1) {
        animation-delay: 0.05s;
    }

    .search-dropdown.open .search-result-item:nth-of-type(2) {
        animation-delay: 0.09s;
    }

    .search-dropdown.open .search-result-item:nth-of-type(3) {
        animation-delay: 0.13s;
    }

    .search-dropdown.open .search-result-item:nth-of-type(4) {
        animation-delay: 0.17s;
    }

    .search-dropdown.open .search-result-item:nth-of-type(5) {
        animation-delay: 0.21s;
    }

    .search-dropdown.open .search-result-item:nth-of-type(6) {
        animation-delay: 0.25s;
    }

    .search-dropdown.open .search-result-item:nth-of-type(7) {
        animation-delay: 0.29s;
    }

    #search-dropdown ::-webkit-scrollbar {
        width: 4px;
    }

    #search-dropdown ::-webkit-scrollbar-track {
        background: transparent;
    }

    #search-dropdown ::-webkit-scrollbar-thumb {
        background: rgba(0, 88, 188, 0.2);
        border-radius: 9999px;
    }
</style>

<script>
    // Database indeks pencarian menu In-TrackFin
    const inTrackSearchIndex = [
        { label: 'Dashboard Overview', desc: 'Ringkasan operasional logistik & kas cabang', icon: 'dashboard', color: 'rgba(0,88,188,0.1)', textColor: 'text-primary', route: '{{ route("dashboard") }}', keywords: 'dashboard beranda overview ringkasan performa cianjur' },
        { label: 'Tracking Resi Pengiriman', desc: 'Cek daftar status resi (tiba, proses, kurir, selesai)', icon: 'inventory_2', color: 'rgba(0,88,188,0.1)', textColor: 'text-primary', route: '{{ route("resi.index") }}', keywords: 'resi tracking paket kirim ekspedisi status pengiriman cianjur' },
        @if(Auth::user()->canManageResi())
            { label: 'Input Resi Baru', desc: 'Formulir input pengiriman paket & resi baru', icon: 'add_box', color: 'rgba(0,110,40,0.1)', textColor: 'text-secondary', route: '{{ route("resi.create") }}', keywords: 'tambah resi buat baru paket pengirim penerima tarif berat' },
        @endif
        @if(Auth::user()->canManageFinance())
                { label: 'Pengeluaran Operasional', desc: 'Beban BBM, armada, maintenance & operasional', icon: 'payments', color: 'rgba(186,26,26,0.1)', textColor: 'text-error', route: '{{ route("expenses.index") }}', keywords: 'pengeluaran beban biaya bbm solar kantor operasional kas keluar' },
            { label: 'Pemasukan Kas & Resi', desc: 'Penerimaan tarif resi dan kas masuk cabang', icon: 'account_balance_wallet', color: 'rgba(0,110,40,0.1)', textColor: 'text-secondary', route: '{{ route("incomes.index") }}', keywords: 'pemasukan kas masuk uang pendapatan tarif omzet' },
            { label: 'Laporan Laba Rugi', desc: 'Laporan keuangan operasional laba kotor & bersih', icon: 'assessment', color: 'rgba(158,61,0,0.1)', textColor: 'text-tertiary', route: '{{ route("reports.index") }}', keywords: 'laporan laba rugi keuangan rekap finansial pdf excel' },
        @endif
        @if(Auth::user()->isKepala())
            { label: 'Kelola Akun Karyawan', desc: 'Manajemen pengguna & hak akses sistem cabang', icon: 'manage_accounts', color: 'rgba(0,88,188,0.1)', textColor: 'text-primary', route: '{{ route("users.index") }}', keywords: 'user pengguna akun karyawan staf role akses kepala cabang' },
        @endif
    ];

    function toggleSearch() {
        const dropdown = document.getElementById('search-dropdown');
        if (!dropdown) return;
        const isOpen = dropdown.classList.contains('open');

        if (isOpen) {
            closeSearch();
        } else {
            dropdown.classList.add('open');
            dropdown.setAttribute('aria-hidden', 'false');
            setTimeout(() => document.getElementById('search-input')?.focus(), 80);
        }
    }

    function closeSearch() {
        const dropdown = document.getElementById('search-dropdown');
        if (dropdown) {
            dropdown.classList.remove('open');
            dropdown.setAttribute('aria-hidden', 'true');
        }
        clearSearch();
    }

    function clearSearch() {
        const input = document.getElementById('search-input');
        if (input) input.value = '';
        document.getElementById('search-clear')?.classList.add('hidden');
        document.getElementById('search-results')?.classList.add('hidden');
        document.getElementById('search-quick')?.classList.remove('hidden');
    }

    function handleSearch(query) {
        const clearBtn = document.getElementById('search-clear');
        const quickSection = document.getElementById('search-quick');
        const resultsSection = document.getElementById('search-results');
        const resultsList = document.getElementById('search-results-list');
        const emptyState = document.getElementById('search-empty');

        clearBtn?.classList.toggle('hidden', query.length === 0);

        const q = query.trim().toLowerCase();
        if (q === '') {
            quickSection?.classList.remove('hidden');
            resultsSection?.classList.add('hidden');
            return;
        }

        quickSection?.classList.add('hidden');
        resultsSection?.classList.remove('hidden');

        const filtered = inTrackSearchIndex.filter(item =>
            item.label.toLowerCase().includes(q) ||
            item.desc.toLowerCase().includes(q) ||
            item.keywords.toLowerCase().includes(q)
        );

        if (filtered.length === 0) {
            if (resultsList) resultsList.innerHTML = '';
            emptyState?.classList.remove('hidden');
            emptyState?.classList.add('flex');
        } else {
            emptyState?.classList.add('hidden');
            emptyState?.classList.remove('flex');
            if (resultsList) {
                resultsList.innerHTML = filtered.map(item => `
                    <a href="${item.route}" class="search-result-item flex items-center gap-3 px-5 py-2.5">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                            style="background: ${item.color};">
                            <span class="material-symbols-outlined text-[16px] ${item.textColor}"
                                style="font-variation-settings:'FILL' 1;">${item.icon}</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-on-surface">${item.label}</p>
                            <p class="text-[11px] text-on-surface-variant/70">${item.desc}</p>
                        </div>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 ml-auto">arrow_forward</span>
                    </a>
                `).join('');
            }
        }
    }

    // Dismiss saat klik di luar
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('search-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            closeSearch();
        }
    });

    // Keyboard shortcut ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeSearch();
        }
    });
</script>