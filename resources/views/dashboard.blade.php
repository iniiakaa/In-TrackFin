@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview Cabang')

@section('content')
    <div class="space-y-8">
        <!-- Header Subtitle -->
        <div>
            <p class="text-x font-semibold tracking-wide text-on-surface-variant/80">Cabang Cianjur &bull;
                {{ now()->translatedFormat('l, d F Y') }}</p>
        </div>

        <!-- Metric Cards (Inventera Liquid Glass Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            <!-- Total Paket Masuk -->
            <div
                class="liquid-glass rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl"
                            style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                    </div>
                    <span class="badge badge-primary">Hari Ini</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Paket Masuk</p>
                    <p class="text-3xl font-extrabold text-on-surface tracking-tight">{{ number_format($totalPaketMasuk) }}
                    </p>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div
                class="liquid-glass rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl"
                            style="font-variation-settings: 'FILL' 1;">trending_up</span>
                    </div>
                    <span class="badge badge-success">+ Pemasukan</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Total Pendapatan</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-secondary tracking-tight">Rp
                        {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div
                class="liquid-glass rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-error/10 text-error flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl"
                            style="font-variation-settings: 'FILL' 1;">trending_down</span>
                    </div>
                    <span class="badge badge-error">Pengeluaran</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Total Pengeluaran</p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-error tracking-tight">Rp
                        {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Laba / Rugi -->
            <div
                class="liquid-glass rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 rounded-2xl {{ $labaRugi >= 0 ? 'bg-primary/10 text-primary' : 'bg-error/10 text-error' }} flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl"
                            style="font-variation-settings: 'FILL' 1;">account_balance</span>
                    </div>
                    <span class="badge {{ $labaRugi >= 0 ? 'badge-primary' : 'badge-error' }}">
                        {{ $labaRugi >= 0 ? 'Laba Bersih' : 'Rugi' }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">
                        {{ $labaRugi >= 0 ? 'Surplus Operasional' : 'Defisit Operasional' }}</p>
                    <p
                        class="text-2xl sm:text-3xl font-extrabold {{ $labaRugi >= 0 ? 'text-primary' : 'text-error' }} tracking-tight">
                        Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Charts & Breakdown Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cash Flow Bar Chart (7 Hari) -->
            <div class="lg:col-span-2 liquid-glass rounded-3xl p-6 sm:p-7 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-on-surface">Arus Kas 7 Hari Terakhir</h3>
                        <p class="text-xs font-medium text-on-surface-variant mt-0.5">Komparasi pendapatan pengiriman vs
                            pengeluaran operasional</p>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-semibold">
                        <span class="flex items-center gap-1.5 text-primary">
                            <span class="w-3 h-3 rounded-full bg-primary inline-block"></span>
                            Pemasukan
                        </span>
                        <span class="flex items-center gap-1.5 text-error">
                            <span class="w-3 h-3 rounded-full bg-error inline-block"></span>
                            Pengeluaran
                        </span>
                    </div>
                </div>
                <div class="w-full relative" style="height: 280px;">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>

            <!-- Status Distribution & Quick Overview -->
            <div class="liquid-glass rounded-3xl p-6 sm:p-7 flex flex-col justify-between gap-6">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-on-surface">Status Pengiriman</h3>
                        <a href="{{ route('resi.index') }}"
                            class="text-xs font-bold text-primary hover:underline flex items-center gap-0.5">
                            Lihat <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <div class="relative flex items-center justify-center my-3" style="height: 160px;">
                        <canvas id="statusChart"></canvas>
                    </div>

                    <!-- Status Legend -->
                    <div class="space-y-2 mt-4 text-xs font-medium">
                        @php
                            $statusConfig = [
                                'tiba_di_cabang' => ['label' => 'Tiba di Cabang', 'color' => '#0058bc'],
                                'sedang_diproses' => ['label' => 'Sedang Diproses', 'color' => '#c64f00'],
                                'dibawa_kurir' => ['label' => 'Dibawa Kurir', 'color' => '#7c3aed'],
                                'selesai' => ['label' => 'Selesai Terkirim', 'color' => '#006e28'],
                            ];
                        @endphp
                        @foreach($statusConfig as $key => $cfg)
                            <div class="flex items-center justify-between py-1 border-b border-black/5 last:border-0">
                                <span class="flex items-center gap-2 text-on-surface-variant">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $cfg['color'] }}"></span>
                                    {{ $cfg['label'] }}
                                </span>
                                <span class="font-bold text-on-surface">{{ $statusCounts[$key] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Stats Summary Card -->
                <div class="p-4 rounded-2xl bg-white/60 border border-white/70 shadow-sm">
                    <div class="flex items-center justify-between text-xs font-semibold py-1">
                        <span class="text-on-surface-variant">Total Resi Aktif</span>
                        <span
                            class="font-bold text-primary">{{ $statusCounts['tiba_di_cabang'] + $statusCounts['sedang_diproses'] + $statusCounts['dibawa_kurir'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs font-semibold py-1 border-t border-black/5">
                        <span class="text-on-surface-variant">Selesai Terkirim</span>
                        <span class="font-bold text-secondary">{{ $statusCounts['selesai'] }}</span>
                    </div>
                    @php $totalAll = array_sum($statusCounts); @endphp
                    <div class="flex items-center justify-between text-xs font-semibold py-1 border-t border-black/5">
                        <span class="text-on-surface-variant">Rasio Penyelesaian</span>
                        <span
                            class="font-bold text-on-surface">{{ $totalAll > 0 ? round(($statusCounts['selesai'] / $totalAll) * 100) : 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Shipments (Inventera Glass Table) -->
        <div class="liquid-glass rounded-3xl p-6 sm:p-7">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-on-surface">Pengiriman Resi Terbaru</h3>
                    <p class="text-xs font-medium text-on-surface-variant mt-0.5">5 resi terakhir yang dicatat ke sistem</p>
                </div>
                <a href="{{ route('resi.index') }}" class="btn btn-ghost btn-sm">
                    <span>Semua Resi</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Resi</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Tujuan</th>
                            <th>Tarif</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentResis as $resi)
                            <tr>
                                <td class="font-mono text-primary font-bold text-xs">{{ $resi->nomor_resi }}</td>
                                <td class="font-semibold text-on-surface">{{ $resi->nama_pengirim }}</td>
                                <td class="text-on-surface">{{ $resi->nama_penerima }}</td>
                                <td class="text-on-surface-variant text-xs">{{ Str::limit($resi->alamat_tujuan, 35) }}</td>
                                <td class="font-bold text-on-surface">Rp {{ number_format($resi->tarif, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match ($resi->status) {
                                            'tiba_di_cabang' => 'badge-tiba',
                                            'sedang_diproses' => 'badge-proses',
                                            'dibawa_kurir' => 'badge-kurir',
                                            'selesai' => 'badge-selesai',
                                            default => 'badge-neutral',
                                        };
                                        $badgeText = match ($resi->status) {
                                            'tiba_di_cabang' => 'Tiba di Cabang',
                                            'sedang_diproses' => 'Sedang Diproses',
                                            'dibawa_kurir' => 'Dibawa Kurir',
                                            'selesai' => 'Selesai',
                                            default => $resi->status,
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-on-surface-variant font-medium">
                                    <span class="material-symbols-outlined text-4xl block mb-2 opacity-40">inventory_2</span>
                                    Belum ada data pengiriman resi saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Cash Flow Chart (Inventera Light Palette)
        const ctx1 = document.getElementById('cashFlowChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($chartPemasukan),
                        backgroundColor: '#0058bc',
                        borderRadius: 8,
                        borderSkipped: false,
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($chartPengeluaran),
                        backgroundColor: '#ba1a1a',
                        borderRadius: 8,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(27, 27, 29, 0.95)',
                        titleColor: '#ffffff',
                        bodyColor: '#eae7ea',
                        padding: 12,
                        cornerRadius: 12,
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#414755', font: { family: 'Inter', size: 11, weight: '500' } },
                        border: { display: false }
                    },
                    y: {
                        grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                        ticks: {
                            color: '#414755',
                            font: { family: 'Inter', size: 10 },
                            callback: (v) => v >= 1000000 ? (v / 1000000).toFixed(1) + 'M' : v >= 1000 ? (v / 1000) + 'K' : v
                        },
                        border: { display: false }
                    }
                }
            }
        });

        // Status Doughnut Chart
        const ctx2 = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Tiba di Cabang', 'Sedang Diproses', 'Dibawa Kurir', 'Selesai'],
                datasets: [{
                    data: [
                        {{ $statusCounts['tiba_di_cabang'] }},
                        {{ $statusCounts['sedang_diproses'] }},
                        {{ $statusCounts['dibawa_kurir'] }},
                        {{ $statusCounts['selesai'] }}
                    ],
                    backgroundColor: ['#0058bc', '#c64f00', '#7c3aed', '#006e28'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    cutout: '72%',
                    spacing: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(27, 27, 29, 0.95)',
                        titleColor: '#ffffff',
                        bodyColor: '#eae7ea',
                        padding: 10,
                        cornerRadius: 12,
                    }
                }
            }
        });
    </script>
@endpush