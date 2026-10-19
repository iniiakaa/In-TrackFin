@extends('layouts.app')

@section('title', 'Pemasukan')
@section('page-title', 'Pemasukan Kas & Resi')

@section('content')
<div class="space-y-6">
    <!-- Filters & Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('incomes.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-input w-44">

            <select name="sumber" class="form-select w-44" onchange="this.form.submit()">
                <option value="">Semua Sumber</option>
                <option value="resi" {{ request('sumber') == 'resi' ? 'selected' : '' }}>Tarif Resi</option>
                <option value="lainnya" {{ request('sumber') == 'lainnya' ? 'selected' : '' }}>Pemasukan Lainnya</option>
            </select>

            <button type="submit" class="btn btn-secondary h-[44px]">
                <span class="material-symbols-outlined text-[18px]">filter_list</span>
                <span>Filter</span>
            </button>
        </form>

        <a href="{{ route('incomes.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Pemasukan Lainnya</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="liquid-glass rounded-3xl overflow-hidden p-2 sm:p-4">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Sumber</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incomes as $income)
                        <tr>
                            <td class="font-medium text-on-surface">{{ $income->tanggal->format('d M Y') }}</td>
                            <td>
                                @if($income->sumber === 'resi')
                                    <span class="badge badge-primary">Resi Otomatis</span>
                                @else
                                    <span class="badge badge-success">Kas Manual</span>
                                @endif
                            </td>
                            <td class="text-on-surface-variant text-sm">{{ $income->keterangan ?? '-' }}</td>
                            <td class="font-bold text-secondary">Rp {{ number_format($income->nominal, 0, ',', '.') }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($income->sumber !== 'resi')
                                        <a href="{{ route('incomes.edit', $income) }}" class="btn-icon w-8 h-8" title="Edit">
                                            <span class="material-symbols-outlined text-[16px]">edit</span>
                                        </a>
                                        <form method="POST" action="{{ route('incomes.destroy', $income) }}" class="inline" onsubmit="return confirm('Hapus pemasukan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon w-8 h-8 text-error hover:bg-error/10 hover:border-error/40" title="Hapus">
                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-on-surface-variant/70 italic px-2">Sistem</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-on-surface-variant font-medium">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-40">savings</span>
                                Belum ada data pemasukan yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($incomes->hasPages())
            <div class="px-4 py-3 border-t border-black/5 pagination-wrapper">
                {{ $incomes->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
