@extends('layouts.app')

@section('title', 'Catat Pemasukan')
@section('page-title', 'Catat Pemasukan Lainnya')

@section('content')
<div class="max-w-xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-black/5">
            <div class="w-10 h-10 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">add_card</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-on-surface">Pemasukan Kas Manual</h3>
                <p class="text-xs font-medium text-on-surface-variant">Tambahkan penerimaan kas di luar tarif resi otomatis</p>
            </div>
        </div>

        <form method="POST" action="{{ route('incomes.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="form-label">Tanggal Pemasukan</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">calendar_today</span>
                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('tanggal') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Nominal (Rp)</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">payments</span>
                    <input type="number" name="nominal" value="{{ old('nominal') }}" min="0" placeholder="Contoh: 75000" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('nominal') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Keterangan Sumber Pemasukan</label>
                <textarea name="keterangan" rows="3" placeholder="Misal: Jasa packing kayu, Premi asuransi, Titipan barang..." class="form-input">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Pemasukan</span>
                </button>
                <a href="{{ route('incomes.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
