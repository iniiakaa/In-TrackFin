@extends('layouts.app')

@section('title', 'Edit Pemasukan')
@section('page-title', 'Edit Data Pemasukan')

@section('content')
<div class="max-w-xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-black/5">
            <div class="w-10 h-10 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">edit</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-on-surface">Perbarui Pemasukan Kas</h3>
                <p class="text-xs font-medium text-on-surface-variant">Ubah data pemasukan manual cabang</p>
            </div>
        </div>

        <form method="POST" action="{{ route('incomes.update', $income) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Tanggal Pemasukan</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">calendar_today</span>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $income->tanggal->format('Y-m-d')) }}" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
            </div>

            <div>
                <label class="form-label">Nominal (Rp)</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">payments</span>
                    <input type="number" name="nominal" value="{{ old('nominal', $income->nominal) }}" min="0" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
            </div>

            <div>
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" rows="3" class="form-input">{{ old('keterangan', $income->keterangan) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
                <a href="{{ route('incomes.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
