@extends('layouts.app')

@section('title', 'Edit Pengeluaran')
@section('page-title', 'Edit Data Pengeluaran')

@section('content')
<div class="max-w-xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-black/5">
            <div class="w-10 h-10 rounded-2xl bg-error/10 text-error flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">edit</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-on-surface">Perbarui Pengeluaran Kas</h3>
                <p class="text-xs font-medium text-on-surface-variant">Ubah informasi rincian biaya operasional</p>
            </div>
        </div>

        <form method="POST" action="{{ route('expenses.update', $expense) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Tanggal Pengeluaran</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">calendar_today</span>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $expense->tanggal->format('Y-m-d')) }}" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
            </div>

            <div>
                <label class="form-label">Kategori Pengeluaran</label>
                <select name="kategori" class="form-select" required>
                    @foreach(['BBM / Solar', 'BBM / Bensin', 'Makan Supir', 'Tol', 'Perawatan Armada', 'ATK & Kantor', 'Listrik & Air', 'Lain-lain'] as $cat)
                        <option value="{{ $cat }}" {{ old('kategori', $expense->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Nominal (Rp)</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">payments</span>
                    <input type="number" name="nominal" value="{{ old('nominal', $expense->nominal) }}" min="0" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
            </div>

            <div>
                <label class="form-label">Keterangan / Rincian</label>
                <textarea name="keterangan" rows="3" class="form-input">{{ old('keterangan', $expense->keterangan) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
                <a href="{{ route('expenses.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
