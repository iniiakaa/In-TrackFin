@extends('layouts.app')

@section('title', 'Pengeluaran')
@section('page-title', 'Pengeluaran Operasional')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar & Action -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('expenses.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-input w-44">

            <select name="kategori" class="form-select w-48" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-secondary h-[44px]">
                <span class="material-symbols-outlined text-[18px]">filter_list</span>
                <span>Filter</span>
            </button>
        </form>

        <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Catat Pengeluaran</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="liquid-glass rounded-3xl overflow-hidden p-2 sm:p-4">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td class="font-medium text-on-surface">{{ $expense->tanggal->format('d M Y') }}</td>
                            <td>
                                <span class="badge badge-error">{{ $expense->kategori }}</span>
                            </td>
                            <td class="text-on-surface-variant text-sm">{{ $expense->keterangan ?? '-' }}</td>
                            <td class="font-bold text-error">Rp {{ number_format($expense->nominal, 0, ',', '.') }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="btn-icon w-8 h-8" title="Edit">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="inline" onsubmit="return confirm('Hapus catatan pengeluaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon w-8 h-8 text-error hover:bg-error/10 hover:border-error/40" title="Hapus">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-on-surface-variant font-medium">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-40">receipt_long</span>
                                Belum ada data pengeluaran yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($expenses->hasPages())
            <div class="px-4 py-3 border-t border-black/5 pagination-wrapper">
                {{ $expenses->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
