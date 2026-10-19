<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Fahlul Amidi',
                'email'    => 'fahlul@intrack.fin',
                'password' => Hash::make('fahlul2025'),
                'role'     => 'kepala_cabang',
            ],
            [
                'name'     => 'Neng Deulis Siti Sadiah',
                'email'    => 'deulis@intrack.fin',
                'password' => Hash::make('deulis2025'),
                'role'     => 'admin_accounting',
            ],
            [
                'name'     => 'Arif Saripudin',
                'email'    => 'arif@intrack.fin',
                'password' => Hash::make('arif2025'),
                'role'     => 'admin_ekspedisi',
            ],
        ];

        // Hapus user lama yang tidak dipakai lagi
        User::whereNotIn('email', array_column($users, 'email'))->delete();

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}

