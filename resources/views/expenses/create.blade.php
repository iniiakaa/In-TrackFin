@extends('layouts.app')

@section('title', 'Catat Pengeluaran')
@section('page-title', 'Catat Pengeluaran Baru')

@section('content')
<div class="max-w-xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-black/5">
            <div class="w-10 h-10 rounded-2xl bg-error/10 text-error flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">trending_down</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-on-surface">Form Pengeluaran Kas</h3>
                <p class="text-xs font-medium text-on-surface-variant">Catat biaya operasional harian cabang</p>
            </div>
        </div>

        <form method="POST" action="{{ route('expenses.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="form-label">Tanggal Pengeluaran</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">calendar_today</span>
                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('tanggal') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Kategori Pengeluaran</label>
                <select name="kategori" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    <option value="BBM / Solar" {{ old('kategori') == 'BBM / Solar' ? 'selected' : '' }}>BBM / Solar</option>
                    <option value="BBM / Bensin" {{ old('kategori') == 'BBM / Bensin' ? 'selected' : '' }}>BBM / Bensin</option>
                    <option value="Makan Supir" {{ old('kategori') == 'Makan Supir' ? 'selected' : '' }}>Makan Supir</option>
                    <option value="Tol" {{ old('kategori') == 'Tol' ? 'selected' : '' }}>Tol</option>
                    <option value="Perawatan Armada" {{ old('kategori') == 'Perawatan Armada' ? 'selected' : '' }}>Perawatan Armada</option>
                    <option value="ATK & Kantor" {{ old('kategori') == 'ATK & Kantor' ? 'selected' : '' }}>ATK & Kantor</option>
                    <option value="Listrik & Air" {{ old('kategori') == 'Listrik & Air' ? 'selected' : '' }}>Listrik & Air</option>
                    <option value="Lain-lain" {{ old('kategori') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                </select>
                @error('kategori') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Nominal (Rp)</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">payments</span>
                    <input type="number" name="nominal" value="{{ old('nominal') }}" min="0" placeholder="Contoh: 150000" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('nominal') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Keterangan / Rincian</label>
                <textarea name="keterangan" rows="3" placeholder="Rincian penggunaan dana operasional..." class="form-input">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Pengeluaran</span>
                </button>
                <a href="{{ route('expenses.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
