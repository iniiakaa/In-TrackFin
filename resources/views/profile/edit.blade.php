<x-app-layout>
    <div class="space-y-6 max-w-4xl">
        <div class="mb-4">
            <h3 class="text-xl font-bold text-on-surface">Pengaturan Profil Pengguna</h3>
            <p class="text-xs font-medium text-on-surface-variant">Kelola nama akun, email, dan kata sandi</p>
        </div>

        <div class="liquid-glass rounded-3xl p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="liquid-glass rounded-3xl p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="liquid-glass rounded-3xl p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
