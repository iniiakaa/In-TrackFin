<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resi;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DummyDataTodaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $today = Carbon::today();
        
        // Get first user or create one if none exists
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin Demo',
                'email' => 'admin@intrack.fin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $userId = $user->id;

        // 1. Generate 10 Resi for today
        $statuses = ['tiba_di_cabang', 'sedang_diproses', 'dibawa_kurir', 'selesai'];
        
        for ($i = 0; $i < 10; $i++) {
            $tarif = $faker->randomFloat(2, 10000, 150000);
            
            $resi = Resi::create([
                'nomor_resi' => Resi::generateNomorResi(),
                'nama_pengirim' => $faker->name,
                'nama_penerima' => $faker->name,
                'alamat_tujuan' => $faker->address,
                'berat_barang' => $faker->randomFloat(2, 0.5, 20),
                'tarif' => $tarif,
                'status' => $faker->randomElement($statuses),
                'catatan' => $faker->optional(0.7)->sentence,
                'user_id' => $userId,
            ]);
            
            // Override created_at/updated_at to be exactly today
            $resi->created_at = $today;
            $resi->updated_at = $today;
            $resi->saveQuietly();

            // 2. Automatically generate Income from Resi for today
            $income = Income::create([
                'tanggal' => $today,
                'sumber' => 'Ongkos Kirim (' . $resi->nomor_resi . ')',
                'nominal' => $tarif,
                'keterangan' => 'Pembayaran ongkos kirim dari pengirim ' . $resi->nama_pengirim,
                'resi_id' => $resi->id,
                'user_id' => $userId,
            ]);
            $income->created_at = $today;
            $income->updated_at = $today;
            $income->saveQuietly();
        }

        // 3. Generate 5 Expenses for today
        $kategoriExpense = ['Operasional', 'Gaji', 'BBM', 'Peralatan', 'Lainnya'];
        
        for ($i = 0; $i < 5; $i++) {
            $expense = Expense::create([
                'tanggal' => $today,
                'kategori' => $faker->randomElement($kategoriExpense),
                'nominal' => $faker->randomFloat(2, 50000, 500000),
                'keterangan' => $faker->sentence,
                'user_id' => $userId,
            ]);
            $expense->created_at = $today;
            $expense->updated_at = $today;
            $expense->saveQuietly();
        }
    }
}
