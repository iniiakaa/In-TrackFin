@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-black/5">
            <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">person_add</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-on-surface">Form Akun Baru</h3>
                <p class="text-xs font-medium text-on-surface-variant">Daftarkan akses karyawan ke sistem In-TrackFin</p>
            </div>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="form-label">Nama Lengkap</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">badge</span>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap karyawan" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Alamat Email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">mail</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@intrack.fin" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Hak Akses / Role</label>
                <select name="role" class="form-select" required>
                    <option value="">Pilih Role Akses</option>
                    @foreach($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Kata Sandi</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">lock</span>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('password') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">lock_reset</span>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span>Buat Akun Pengguna</span>
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
