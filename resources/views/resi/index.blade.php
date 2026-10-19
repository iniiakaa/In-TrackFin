@extends('layouts.app')

@section('title', 'Tracking Resi')
@section('page-title', 'Tracking Resi Pengiriman')

@section('content')
<div class="space-y-6">
    <!-- Filters & Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('resi.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-initial">
                <span class="material-symbols-outlined absolute left-4 top-1/2 text-[20px] text-on-surface-variant/60 pointer-events-none select-none">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor resi / pengirim..." class="form-input w-full sm:w-64" style="padding-left: 2.65rem;">
            </div>

            <div class="relative">
                <select name="status" class="form-select w-44" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="tiba_di_cabang" {{ request('status') == 'tiba_di_cabang' ? 'selected' : '' }}>Tiba di Cabang</option>
                    <option value="sedang_diproses" {{ request('status') == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                    <option value="dibawa_kurir" {{ request('status') == 'dibawa_kurir' ? 'selected' : '' }}>Dibawa Kurir</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai Terkirim</option>
                </select>
            </div>

            <button type="submit" class="btn btn-secondary h-[44px]">
                <span class="material-symbols-outlined text-[18px]">filter_list</span>
                <span>Filter</span>
            </button>
        </form>

        <div class="flex items-center gap-2 flex-shrink-0">
            {{-- Export: hanya Admin Accounting --}}
            @if(Auth::user()->isAdminAccounting())
            <a href="{{ route('resi.exportCsv', array_filter(['search' => request('search'), 'status' => request('status')])) }}"
               class="btn btn-success btn-sm" title="Export ke CSV/Excel">
                <span class="material-symbols-outlined text-[18px]">table_view</span>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('resi.exportPdf', array_filter(['search' => request('search'), 'status' => request('status')])) }}"
               class="btn btn-danger btn-sm" title="Cetak PDF">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Cetak PDF</span>
            </a>
            @endif

            @if(Auth::user()->canManageResi())
            <a href="{{ route('resi.create') }}" class="btn btn-primary btn-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>Tambah Resi Baru</span>
            </a>
            @endif
        </div>

    </div>


    <!-- Table Card (Inventera Liquid Glass) -->
    <div class="liquid-glass rounded-3xl overflow-hidden p-2 sm:p-4">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Resi</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Tujuan</th>
                        <th>Berat</th>
                        <th>Tarif</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resis as $resi)
                        <tr>
                            <td>
                                <a href="{{ route('resi.show', $resi) }}" class="font-mono text-primary font-bold text-xs hover:underline flex items-center gap-1">
                                    {{ $resi->nomor_resi }}
                                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                </a>
                            </td>
                            <td class="font-semibold text-on-surface">{{ $resi->nama_pengirim }}</td>
                            <td class="text-on-surface">{{ $resi->nama_penerima }}</td>
                            <td class="text-on-surface-variant text-xs">{{ Str::limit($resi->alamat_tujuan, 35) }}</td>
                            <td class="text-on-surface font-medium">{{ $resi->berat_barang }} kg</td>
                            <td class="font-bold text-on-surface">Rp {{ number_format($resi->tarif, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = match($resi->status) {
                                        'tiba_di_cabang' => 'badge-tiba',
                                        'sedang_diproses' => 'badge-proses',
                                        'dibawa_kurir' => 'badge-kurir',
                                        'selesai' => 'badge-selesai',
                                        default => 'badge-neutral',
                                    };
                                    $badgeText = match($resi->status) {
                                        'tiba_di_cabang' => 'Tiba di Cabang',
                                        'sedang_diproses' => 'Sedang Diproses',
                                        'dibawa_kurir' => 'Dibawa Kurir',
                                        'selesai' => 'Selesai',
                                        default => $resi->status,
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Quick Step Progression --}}
                                    @if($resi->status !== 'selesai' && Auth::user()->canManageResi())
                                    <form method="POST" action="{{ route('resi.updateStatus', $resi) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @php
                                            $nextStatus = match($resi->status) {
                                                'tiba_di_cabang' => 'sedang_diproses',
                                                'sedang_diproses' => 'dibawa_kurir',
                                                'dibawa_kurir' => 'selesai',
                                                default => null,
                                            };
                                            $nextLabel = match($nextStatus) {
                                                'sedang_diproses' => 'Proses',
                                                'dibawa_kurir' => 'Kirim',
                                                'selesai' => 'Selesai',
                                                default => '',
                                            };
                                        @endphp
                                        <input type="hidden" name="status" value="{{ $nextStatus }}">
                                        <button type="submit" class="btn btn-success btn-sm py-1 px-2.5 text-xs" title="Perbarui status ke {{ $nextLabel }}">
                                            <span class="material-symbols-outlined text-[14px]">fast_forward</span>
                                            <span>{{ $nextLabel }}</span>
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('resi.show', $resi) }}" class="btn-icon w-8 h-8" title="Detail Resi">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    </a>

                                    @if(Auth::user()->canManageResi())
                                    <a href="{{ route('resi.edit', $resi) }}" class="btn-icon w-8 h-8" title="Edit Resi">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>

                                    <form method="POST" action="{{ route('resi.destroy', $resi) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resi {{ $resi->nomor_resi }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon w-8 h-8 text-error hover:bg-error/10 hover:border-error/40" title="Hapus">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-on-surface-variant font-medium">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-40">inventory_2</span>
                                Tidak ada data pengiriman resi yang sesuai pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($resis->hasPages())
            <div class="px-4 py-3 border-t border-black/5 pagination-wrapper">
                {{ $resis->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
