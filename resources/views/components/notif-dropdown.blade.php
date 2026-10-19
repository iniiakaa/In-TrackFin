@props(['notifications' => []])

@php
    // Ambil ringkasan aktivitas operasional In-TrackFin terkini
    try {
        $recentResis = \App\Models\Resi::latest()->take(3)->get();
        $recentExpenses = \App\Models\Expense::latest()->take(2)->get();
    } catch (\Throwable $e) {
        $recentResis = collect();
        $recentExpenses = collect();
    }
@endphp

<div class="relative" id="notif-wrapper">
    <!-- Bell Button -->
    <button id="notif-btn" type="button" onclick="toggleNotif()"
        class="relative w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant transition-all duration-200 hover:text-on-surface hover:bg-white/60 active:scale-95"
        style="background: rgba(255,255,255,0.25); backdrop-filter: blur(80px) saturate(2.2) brightness(1.06); -webkit-backdrop-filter: blur(80px) saturate(2.2) brightness(1.06); border: 1px solid rgba(255,255,255,0.85); box-shadow: 0 4px 16px rgba(0,88,188,0.04), inset 0 1.5px 0 rgba(255,255,255,0.95);"
        aria-label="Notifikasi" title="Notifikasi Sistem">
        <span class="material-symbols-outlined text-[20px]">notifications</span>
        <!-- Unread pulsing dot -->
        <span id="notif-dot"
            class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-error rounded-full border-2 border-surface animate-pulse"></span>
    </button>

    <!-- Dropdown Panel (Liquid Frosted Glass Style) -->
    <div id="notif-dropdown"
        class="notif-dropdown absolute right-0 mt-3 w-[360px] sm:w-[390px] z-50 origin-top-right rounded-[24px]"
        aria-hidden="true">

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/40">
            <div>
                <h3 class="text-sm font-bold text-on-surface">Notifikasi</h3>
                <p class="text-[11px] font-medium text-on-surface-variant mt-0.5" id="notif-unread-count">Pembaruan
                    Operasional Logistik</p>
            </div>
            <button type="button" onclick="markAllNotifsAsRead()"
                class="text-xs font-semibold text-primary hover:opacity-70 transition-opacity">
                Tandai semua dibaca
            </button>
        </div>

        <!-- List -->
        <ul class="divide-y divide-white/25 max-h-[380px] overflow-y-auto" id="notif-list">
            @if($recentResis->isNotEmpty())
                @foreach($recentResis as $resi)
                    @php
                        $icon = 'inventory_2';
                        $color = 'text-primary';
                        $bg = 'rgba(0,88,188,0.1)';
                        $title = 'Resi ' . $resi->nomor_resi;
                        if ($resi->status === 'selesai') {
                            $icon = 'check_circle';
                            $color = 'text-secondary';
                            $bg = 'rgba(0,110,40,0.1)';
                            $title = 'Pengiriman Selesai Terkirim';
                        } elseif ($resi->status === 'dibawa_kurir') {
                            $icon = 'local_shipping';
                            $color = 'text-tertiary';
                            $bg = 'rgba(158,61,0,0.1)';
                            $title = 'Paket Sedang Dibawa Kurir';
                        } elseif ($resi->status === 'sedang_diproses') {
                            $icon = 'sync';
                            $color = 'text-primary';
                            $bg = 'rgba(0,88,188,0.1)';
                            $title = 'Resi Sedang Diproses Cabang';
                        } else {
                            $icon = 'inventory_2';
                            $color = 'text-primary';
                            $bg = 'rgba(0,88,188,0.1)';
                            $title = 'Resi Tiba di Cabang Cianjur';
                        }
                    @endphp
                    <li class="notif-item flex items-start gap-3 px-5 py-3.5 relative">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                            style="background: {{ $bg }};">
                            <span class="material-symbols-outlined text-[18px] {{ $color }}"
                                style="font-variation-settings:'FILL' 1;">{{ $icon }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-on-surface truncate">{{ $title }}</p>
                            <p class="text-[12px] text-on-surface-variant mt-0.5 line-clamp-2 leading-relaxed">
                                Resi #{{ $resi->nomor_resi }} &bull; Penerima: {{ $resi->nama_penerima }}
                            </p>
                            <p class="text-[10px] font-semibold text-on-surface-variant/60 mt-1">
                                {{ $resi->created_at ? $resi->created_at->diffForHumans() : 'Baru saja' }}
                            </p>
                        </div>
                        <span class="notif-badge-unread w-2 h-2 rounded-full bg-primary flex-shrink-0 mt-2"></span>
                    </li>
                @endforeach
            @endif

            @if($recentExpenses->isNotEmpty())
                @foreach($recentExpenses as $expense)
                    <li class="notif-item flex items-start gap-3 px-5 py-3.5 relative">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                            style="background: rgba(158,61,0,0.1);">
                            <span class="material-symbols-outlined text-[18px] text-tertiary"
                                style="font-variation-settings:'FILL' 1;">payments</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-on-surface">Biaya Operasional: {{ $expense->kategori }}</p>
                            <p class="text-[12px] text-on-surface-variant mt-0.5 truncate leading-relaxed">
                                Nominal: Rp {{ number_format($expense->nominal, 0, ',', '.') }} @if($expense->keterangan)&bull;
                                {{ $expense->keterangan }}@endif
                            </p>
                            <p class="text-[10px] font-semibold text-on-surface-variant/60 mt-1">
                                {{ $expense->created_at ? $expense->created_at->diffForHumans() : 'Hari ini' }}
                            </p>
                        </div>
                        <span class="notif-badge-unread w-2 h-2 rounded-full bg-tertiary flex-shrink-0 mt-2"></span>
                    </li>
                @endforeach
            @endif

            <!-- Info Keamanan & Sesi (Static item) -->
            <li class="notif-item flex items-start gap-3 px-5 py-3.5 opacity-60 relative">
                <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                    style="background: rgba(65,71,85,0.08);">
                    <span class="material-symbols-outlined text-[18px] text-on-surface-variant"
                        style="font-variation-settings:'FILL' 1;">verified_user</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-on-surface">Sesi Akun Aktif</p>
                    <p class="text-[12px] text-on-surface-variant mt-0.5 leading-relaxed">
                        Login sebagai {{ Auth::user()->name ?? 'Karyawan' }} ({{ Auth::user()->role_label ?? 'Staff' }})
                    </p>
                    <p class="text-[10px] font-semibold text-on-surface-variant/60 mt-1">Sesi saat ini</p>
                </div>
            </li>
        </ul>

        <!-- Footer -->
        <div class="px-5 py-3.5 border-t border-white/30">
            <a href="{{ route('resi.index') }}"
                class="flex items-center justify-center gap-1.5 text-xs font-bold text-primary hover:opacity-70 transition-opacity">
                <span>Lihat semua aktivitas resi & pengiriman</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<style>
    /* Gaussian Blur - Apple Frosted Glass Style */
    #notif-dropdown {
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

    #notif-dropdown::before {
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

    #notif-dropdown>* {
        position: relative;
        z-index: 1;
    }

    /* Dropdown Animations */
    .notif-dropdown {
        pointer-events: none;
        opacity: 0;
        transform: scale(0.92) translateY(-8px);
        transform-origin: top right;
        transition:
            opacity 0.28s cubic-bezier(0.32, 0.72, 0, 1),
            transform 0.28s cubic-bezier(0.32, 0.72, 0, 1);
        will-change: transform, opacity;
    }

    .notif-dropdown.open {
        pointer-events: auto;
        opacity: 1;
        transform: scale(1) translateY(0);
    }

    .notif-item {
        cursor: pointer;
        transition: background 0.18s ease;
    }

    .notif-item:hover {
        background: rgba(255, 255, 255, 0.4);
    }

    @keyframes fadeInUpItem {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notif-dropdown.open .notif-item {
        animation: fadeInUpItem 0.35s cubic-bezier(0.32, 0.72, 0, 1) both;
    }

    .notif-dropdown.open .notif-item:nth-child(1) {
        animation-delay: 0.06s;
    }

    .notif-dropdown.open .notif-item:nth-child(2) {
        animation-delay: 0.11s;
    }

    .notif-dropdown.open .notif-item:nth-child(3) {
        animation-delay: 0.16s;
    }

    .notif-dropdown.open .notif-item:nth-child(4) {
        animation-delay: 0.21s;
    }

    .notif-dropdown.open .notif-item:nth-child(5) {
        animation-delay: 0.26s;
    }

    .notif-dropdown.open .notif-item:nth-child(6) {
        animation-delay: 0.31s;
    }

    #notif-dropdown ::-webkit-scrollbar {
        width: 4px;
    }

    #notif-dropdown ::-webkit-scrollbar-track {
        background: transparent;
    }

    #notif-dropdown ::-webkit-scrollbar-thumb {
        background: rgba(0, 88, 188, 0.2);
        border-radius: 9999px;
    }
</style>

<script>
    function toggleNotif() {
        const dropdown = document.getElementById('notif-dropdown');
        if (!dropdown) return;
        const isOpen = dropdown.classList.contains('open');

        if (isOpen) {
            dropdown.classList.remove('open');
            dropdown.setAttribute('aria-hidden', 'true');
        } else {
            dropdown.classList.add('open');
            dropdown.setAttribute('aria-hidden', 'false');
        }
    }

    function markAllNotifsAsRead() {
        const dot = document.getElementById('notif-dot');
        if (dot) {
            dot.style.transition = 'opacity 0.3s ease';
            dot.style.opacity = '0';
            setTimeout(() => dot.remove(), 300);
        }
        const count = document.getElementById('notif-unread-count');
        if (count) {
            count.textContent = 'Semua sudah dibaca';
        }
        document.querySelectorAll('.notif-badge-unread').forEach(el => el.remove());
        document.querySelectorAll('.notif-item').forEach(el => el.classList.add('opacity-60'));
    }

    // Dismiss saat klik di luar
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('notif-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            const dropdown = document.getElementById('notif-dropdown');
            if (dropdown && dropdown.classList.contains('open')) {
                dropdown.classList.remove('open');
                dropdown.setAttribute('aria-hidden', 'true');
            }
        }
    });
</script>