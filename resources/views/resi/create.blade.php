@extends('layouts.app')

@section('title', 'Tambah Resi')
@section('page-title', 'Tambah Resi Baru')

@section('content')
<div class="max-w-3xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-black/5">
            <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">add_box</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-on-surface">Form Input Pengiriman Baru</h3>
                <p class="text-xs font-medium text-on-surface-variant">Lengkapi informasi pengirim, penerima, dan tarif paket</p>
            </div>
        </div>

        <form method="POST" action="{{ route('resi.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nama Pengirim</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">person</span>
                        <input type="text" name="nama_pengirim" value="{{ old('nama_pengirim') }}" placeholder="Contoh: PT Sumber Rezeki / Ahmad" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('nama_pengirim') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Nama Penerima</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">person_pin</span>
                        <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}" placeholder="Contoh: Siti Rahma" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('nama_penerima') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="form-label">Alamat Tujuan Pengiriman</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-3 text-on-surface-variant/70 text-[20px]">location_on</span>
                        <textarea name="alamat_tujuan" rows="3" placeholder="Masukkan alamat lengkap tujuan pengiriman..." class="form-input" style="padding-left: 2.65rem;" required>{{ old('alamat_tujuan') }}</textarea>
                    </div>
                    @error('alamat_tujuan') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Berat Barang (kg)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">weight</span>
                        <input type="number" name="berat_barang" value="{{ old('berat_barang') }}" step="0.1" min="0.1" placeholder="Contoh: 2.5" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('berat_barang') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Tarif Pengiriman (Rp)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 text-on-surface-variant/70 text-[20px]">payments</span>
                        <input type="number" name="tarif" value="{{ old('tarif') }}" min="0" placeholder="Contoh: 35000" class="form-input" style="padding-left: 2.65rem;" required>
                    </div>
                    @error('tarif') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="2" placeholder="Instruksi penanganan khusus atau keterangan paket..." class="form-input">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span>Simpan Data Resi</span>
                </button>
                <a href="{{ route('resi.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
