@extends('layouts.app')

@section('title', 'Edit Resi')
@section('page-title', 'Edit Data Resi')

@section('content')
<div class="max-w-3xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center justify-between gap-3 mb-6 pb-4 border-b border-black/5">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl">edit_note</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-on-surface">Perbarui Informasi Resi</h3>
                    <p class="font-mono text-xs font-bold text-primary">{{ $resi->nomor_resi }}</p>
                </div>
            </div>
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
        </div>

        <form method="POST" action="{{ route('resi.update', $resi) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Pengirim</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">person</span>
                        <input type="text" name="nama_pengirim" value="{{ old('nama_pengirim', $resi->nama_pengirim) }}" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('nama_pengirim') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Nama Penerima</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">person_pin</span>
                        <input type="text" name="nama_penerima" value="{{ old('nama_penerima', $resi->nama_penerima) }}" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('nama_penerima') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="form-label">Alamat Tujuan</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-3 text-on-surface-variant/70 text-[20px]">location_on</span>
                        <textarea name="alamat_tujuan" rows="3" class="form-input" style="padding-left: 2.65rem;" required>{{ old('alamat_tujuan', $resi->alamat_tujuan) }}</textarea>
                    </div>
                    @error('alamat_tujuan') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Berat Barang (kg)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">weight</span>
                        <input type="number" name="berat_barang" value="{{ old('berat_barang', $resi->berat_barang) }}" step="0.1" min="0.1" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('berat_barang') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Tarif Pengiriman (Rp)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">payments</span>
                        <input type="number" name="tarif" value="{{ old('tarif', $resi->tarif) }}" min="0" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('tarif') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="2" class="form-input">{{ old('catatan', $resi->catatan) }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
                <a href="{{ route('resi.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
