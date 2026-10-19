@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')
@section('page-title', 'Laporan Laba Rugi Operasional')

@section('content')
<div class="space-y-6">
    <!-- Filter & Export Bar (Inventera Liquid Glass) -->
    <div class="liquid-glass rounded-3xl p-5 sm:p-6">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="form-label">Periode</label>
                <select name="filter" class="form-select w-36">
                    <option value="hari" {{ $filter == 'hari' ? 'selected' : '' }}>Harian</option>
                    <option value="minggu" {{ $filter == 'minggu' ? 'selected' : '' }}>Mingguan</option>
                    <option value="bulan" {{ $filter == 'bulan' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </div>

            <div>
                <label class="form-label">Tanggal Acuan</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-input w-44">
            </div>

            <button type="submit" class="btn btn-primary h-[44px]">
                <span class="material-symbols-outlined text-[18px]">query_stats</span>
                <span>Tampilkan Laporan</span>
            </button>

            @if(Auth::user()->isAdminAccounting())
            <div class="ml-auto flex items-center gap-2 pt-2 sm:pt-0">
                <a href="{{ route('reports.exportPdf', ['filter' => $filter, 'tanggal' => $tanggal]) }}" class="btn btn-danger btn-sm">
                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                    <span>Cetak PDF</span>
                </a>
                <a href="{{ route('reports.exportExcel', ['filter' => $filter, 'tanggal' => $tanggal]) }}" class="btn btn-success btn-sm">
                    <span class="material-symbols-outlined text-[18px]">table_view</span>
                    <span>Export CSV</span>
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Active Period Label -->
    <div class="flex items-center gap-2 px-2">
        <span class="material-symbols-outlined text-primary text-[20px]">date_range</span>
        <h3 class="text-base font-bold text-on-surface">Periode: {{ $periodLabel }}</h3>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Pemasukan -->
        <div class="liquid-glass rounded-3xl p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Total Pemasukan</span>
                <div class="w-10 h-10 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">trending_up</span>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-secondary tracking-tight">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>

        <!-- Pengeluaran -->
        <div class="liquid-glass rounded-3xl p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Total Pengeluaran</span>
                <div class="w-10 h-10 rounded-2xl bg-error/10 text-error flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">trending_down</span>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-error tracking-tight">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>

        <!-- Laba Rugi -->
        <div class="liquid-glass rounded-3xl p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">{{ $labaRugi >= 0 ? 'Surplus Laba' : 'Defisit Rugi' }}</span>
                <div class="w-10 h-10 rounded-2xl {{ $labaRugi >= 0 ? 'bg-primary/10 text-primary' : 'bg-error/10 text-error' }} flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">account_balance</span>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold {{ $labaRugi >= 0 ? 'text-primary' : 'text-error' }} tracking-tight">
                Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Tables Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pemasukan Table -->
        <div class="liquid-glass rounded-3xl overflow-hidden p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-2.5 pb-4 mb-3 border-b border-black/5">
                    <div class="w-8 h-8 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                    </div>
                    <h4 class="text-sm font-bold text-on-surface">Rincian Pemasukan Kas</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Sumber</th>
                                <th>Keterangan</th>
                                <th class="text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incomes as $income)
                                <tr>
                                    <td class="text-xs font-medium">{{ $income->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        @if($income->sumber === 'resi')
                                            <span class="badge badge-primary text-[10px] py-0.5 px-2">Resi</span>
                                        @else
                                            <span class="badge badge-success text-[10px] py-0.5 px-2">Manual</span>
                                        @endif
                                    </td>
                                    <td class="text-xs text-on-surface-variant">{{ Str::limit($income->keterangan ?? '-', 25) }}</td>
                                    <td class="text-right font-bold text-secondary text-xs">Rp {{ number_format($income->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-on-surface-variant/60 py-8">Tidak ada data pemasukan pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-black/10 font-bold bg-white/40">
                                <td colspan="3" class="py-3 px-4 text-xs uppercase tracking-wider text-on-surface">Total Pemasukan</td>
                                <td class="text-right text-secondary py-3 px-4 text-sm font-extrabold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($pemasukanBySource->count())
            <div class="mt-4 pt-4 border-t border-black/5 bg-white/30 rounded-2xl p-3.5">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">Ringkasan per Sumber:</p>
                @foreach($pemasukanBySource as $src => $total)
                    <div class="flex justify-between text-xs py-1 border-b border-black/5 last:border-0">
                        <span class="text-on-surface font-medium">{{ $src === 'resi' ? 'Tarif Resi Pengiriman' : 'Pemasukan Kas Lainnya' }}</span>
                        <span class="text-secondary font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Pengeluaran Table -->
        <div class="liquid-glass rounded-3xl overflow-hidden p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-2.5 pb-4 mb-3 border-b border-black/5">
                    <div class="w-8 h-8 rounded-xl bg-error/10 text-error flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                    </div>
                    <h4 class="text-sm font-bold text-on-surface">Rincian Pengeluaran Kas</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th class="text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                                <tr>
                                    <td class="text-xs font-medium">{{ $expense->tanggal->format('d/m/Y') }}</td>
                                    <td><span class="badge badge-error text-[10px] py-0.5 px-2">{{ $expense->kategori }}</span></td>
                                    <td class="text-xs text-on-surface-variant">{{ Str::limit($expense->keterangan ?? '-', 25) }}</td>
                                    <td class="text-right font-bold text-error text-xs">Rp {{ number_format($expense->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-on-surface-variant/60 py-8">Tidak ada data pengeluaran pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-black/10 font-bold bg-white/40">
                                <td colspan="3" class="py-3 px-4 text-xs uppercase tracking-wider text-on-surface">Total Pengeluaran</td>
                                <td class="text-right text-error py-3 px-4 text-sm font-extrabold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($pengeluaranByCategory->count())
            <div class="mt-4 pt-4 border-t border-black/5 bg-white/30 rounded-2xl p-3.5">
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">Ringkasan per Kategori:</p>
                @foreach($pengeluaranByCategory as $cat => $total)
                    <div class="flex justify-between text-xs py-1 border-b border-black/5 last:border-0">
                        <span class="text-on-surface font-medium">{{ $cat }}</span>
                        <span class="text-error font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
