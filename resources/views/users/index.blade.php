@extends('layouts.app')

@section('title', 'Kelola Akun')
@section('page-title', 'Kelola Pengguna Sistem')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-on-surface-variant">
                Total <span class="font-bold text-on-surface">{{ $users->count() }}</span> pengguna internal terdaftar dalam sistem
            </p>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Users Table Card (Inventera Liquid Glass) -->
    <div class="liquid-glass rounded-3xl overflow-hidden p-2 sm:p-4">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Hak Akses / Role</th>
                        <th>Terdaftar Sejak</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm text-primary bg-primary/10 flex-shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-on-surface flex items-center gap-1.5">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="badge badge-primary text-[10px] py-0 px-1.5">Anda</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-on-surface font-medium text-sm">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'kepala_cabang')
                                    <span class="badge badge-primary">Kepala Cabang</span>
                                @elseif($user->role === 'admin_accounting')
                                    <span class="badge badge-success">Admin Accounting</span>
                                @elseif($user->role === 'admin_ekspedisi')
                                    <span class="badge badge-warning">Admin Ekspedisi</span>
                                @else
                                    <span class="badge badge-neutral">{{ $user->role_label }}</span>
                                @endif
                            </td>
                            <td class="text-on-surface-variant text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('users.edit', $user) }}" class="btn-icon w-8 h-8" title="Edit Pengguna">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon w-8 h-8 text-error hover:bg-error/10 hover:border-error/40" title="Hapus Akun">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-on-surface-variant font-medium">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-40">group</span>
                                Belum ada data pengguna yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
