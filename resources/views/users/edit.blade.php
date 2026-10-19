@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Akun Pengguna')

@section('content')
<div class="max-w-xl">
    <div class="liquid-glass rounded-3xl p-6 sm:p-8">
        <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-black/5">
            <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-2xl">manage_accounts</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-on-surface">Perbarui Informasi Akun</h3>
                <p class="text-xs font-medium text-on-surface-variant">{{ $user->name }} &bull; {{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Nama Lengkap</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">badge</span>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Alamat Email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">mail</span>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" style="padding-left: 2.6rem;" required>
                </div>
                @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Hak Akses / Role</label>
                <select name="role" class="form-select" required>
                    <option value="">Pilih Role Akses</option>
                    @foreach($roles as $value => $label)
                        <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-black/5">
                <p class="text-xs font-semibold text-on-surface-variant mb-4">Ubah Kata Sandi (Kosongkan jika tidak ingin mengubah)</p>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">lock</span>
                            <input type="password" name="password" placeholder="Minimal 6 karakter" class="form-input" style="padding-left: 2.6rem;">
                        </div>
                        @error('password') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant/70 text-[20px]">lock_reset</span>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="form-input" style="padding-left: 2.6rem;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-black/5">
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
