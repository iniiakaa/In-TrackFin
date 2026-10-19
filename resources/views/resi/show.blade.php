@extends('layouts.app')

@section('title', 'Detail Resi')
@section('page-title', 'Detail Resi Pengiriman')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-5 border-b border-black/5">
            <div class="flex items-center space-x-3.5">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl">local_shipping</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-on-surface">Informasi Resi</h3>
                    <p class="font-mono text-sm font-bold text-primary">{{ $resi->nomor_resi }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
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
                        'selesai' => 'Selesai Terkirim',
                        default => $resi->status,
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>

                @if(Auth::user()->canManageResi())
                <a href="{{ route('resi.edit', $resi) }}" class="btn btn-secondary btn-sm">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    <span>Edit</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-white/40 rounded-2xl p-5 border border-white/60 mb-6">
            <div>
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Pengirim</p>
                <p class="text-base font-bold text-on-surface">{{ $resi->nama_pengirim }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Penerima</p>
                <p class="text-base font-bold text-on-surface">{{ $resi->nama_penerima }}</p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Alamat Tujuan</p>
                <p class="text-sm font-medium text-on-surface leading-relaxed">{{ $resi->alamat_tujuan }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Berat Barang</p>
                <p class="text-base font-bold text-on-surface">{{ $resi->berat_barang }} kg</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Total Biaya / Tarif</p>
                <p class="text-xl font-extrabold text-secondary">Rp {{ number_format($resi->tarif, 0, ',', '.') }}</p>
            </div>
            @if($resi->catatan)
            <div class="sm:col-span-2">
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Catatan Paket</p>
                <p class="text-sm text-on-surface bg-white/50 p-3 rounded-xl border border-black/5">{{ $resi->catatan }}</p>
            </div>
            @endif
            <div>
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Waktu Didaftarkan</p>
                <p class="text-xs font-medium text-on-surface">{{ $resi->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Terakhir Diperbarui</p>
                <p class="text-xs font-medium text-on-surface">{{ $resi->updated_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Status Stepper Flow -->
        <div class="mt-8 pt-6 border-t border-black/5">
            <h4 class="text-sm font-bold text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">alt_route</span>
                <span>Progres Pengiriman</span>
            </h4>
            <div class="grid grid-cols-4 gap-2 relative">
                @php
                    $allStatuses = ['tiba_di_cabang', 'sedang_diproses', 'dibawa_kurir', 'selesai'];
                    $currentIndex = array_search($resi->status, $allStatuses);
                    $labels = ['Tiba di Cabang', 'Diproses', 'Kurir Jalan', 'Selesai'];
                    $icons = ['warehouse', 'move_to_inbox', 'two_wheeler', 'check_circle'];
                @endphp
                @foreach($allStatuses as $idx => $st)
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 {{ $idx <= $currentIndex ? 'bg-primary text-white shadow-md shadow-primary/30' : 'bg-surface-container text-on-surface-variant/50 border border-black/5' }}">
                            <span class="material-symbols-outlined text-[20px]">{{ $icons[$idx] }}</span>
                        </div>
                        <p class="text-xs font-semibold mt-2 {{ $idx <= $currentIndex ? 'text-primary font-bold' : 'text-on-surface-variant/60' }}">{{ $labels[$idx] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-black/5 flex items-center justify-between">
            <a href="{{ route('resi.index') }}" class="btn btn-ghost btn-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Daftar</span>
            </a>

            @if($resi->status !== 'selesai' && Auth::user()->canManageResi())
            <form method="POST" action="{{ route('resi.updateStatus', $resi) }}">
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
                        'sedang_diproses' => 'Proses Paket',
                        'dibawa_kurir' => 'Kirim Bersama Kurir',
                        'selesai' => 'Tandai Selesai Terkirim',
                        default => '',
                    };
                @endphp
                <input type="hidden" name="status" value="{{ $nextStatus }}">
                <button type="submit" class="btn btn-primary btn-sm">
                    <span class="material-symbols-outlined text-[18px]">fast_forward</span>
                    <span>{{ $nextLabel }}</span>
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
