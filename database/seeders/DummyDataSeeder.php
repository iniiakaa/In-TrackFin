<?php

namespace Database\Seeders;

use App\Models\Resi;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = 1;

        $destinations = [
            'Bandung', 'Jakarta', 'Surabaya', 'Semarang', 'Yogyakarta',
            'Bogor', 'Depok', 'Tangerang', 'Bekasi', 'Cirebon',
            'Garut', 'Tasikmalaya', 'Sukabumi', 'Karawang', 'Purwakarta',
        ];

        $senders = [
            'Ahmad Fadli', 'Budi Santoso', 'Citra Dewi', 'Dina Amalia', 'Eko Prasetyo',
            'Fani Nugraha', 'Gilang Ramadan', 'Hesti Wulandari', 'Irfan Hakim', 'Joko Widodo',
            'Kartika Sari', 'Lina Marlina', 'Mulyadi', 'Nina Kurnia', 'Oscar Pratama',
        ];

        $receivers = [
            'PT Maju Jaya', 'CV Karya Utama', 'Ibu Siti Aisyah', 'Bpk Handoko', 'Toko Berkah',
            'PT Sejahtera', 'CV Mandiri', 'Bu Ratna', 'Pak Darmawan', 'UD Makmur',
            'PT Global Indo', 'CV Sentosa', 'Ibu Yanti', 'Bpk Sugiarto', 'Toko Abadi',
        ];

        $statuses = ['tiba_di_cabang', 'sedang_diproses', 'dibawa_kurir', 'selesai'];
        $expenseCategories = ['BBM / Solar', 'BBM / Bensin', 'Makan Supir', 'Tol', 'Perawatan Armada', 'ATK & Kantor', 'Listrik & Air', 'Lain-lain'];

        // Create 50 resis over the past 14 days
        for ($i = 0; $i < 50; $i++) {
            $daysAgo = rand(0, 13);
            $date = Carbon::today()->subDays($daysAgo);
            $status = $statuses[array_rand($statuses)];

            // Make more recent resis have earlier statuses
            if ($daysAgo <= 1) {
                $status = $statuses[rand(0, 2)]; // not selesai for very recent
            }
            if ($daysAgo >= 5) {
                $status = 'selesai'; // older ones are completed
            }

            $tarif = rand(15, 250) * 1000; // 15k - 250k
            $berat = rand(1, 500) / 10; // 0.1 - 50.0 kg

            $resi = Resi::create([
                'nomor_resi' => 'CJR-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nama_pengirim' => $senders[array_rand($senders)],
                'nama_penerima' => $receivers[array_rand($receivers)],
                'alamat_tujuan' => $destinations[array_rand($destinations)],
                'berat_barang' => $berat,
                'tarif' => $tarif,
                'status' => $status,
                'user_id' => $adminId,
                'created_at' => $date->copy()->addHours(rand(7, 10))->addMinutes(rand(0, 59)),
                'updated_at' => $date->copy()->addHours(rand(14, 18))->addMinutes(rand(0, 59)),
            ]);

            // Create income for completed resis
            if ($status === 'selesai') {
                Income::create([
                    'tanggal' => $date->toDateString(),
                    'sumber' => 'resi',
                    'nominal' => $tarif,
                    'keterangan' => "Ongkir resi {$resi->nomor_resi} - {$resi->nama_pengirim} ke {$resi->nama_penerima}",
                    'resi_id' => $resi->id,
                    'user_id' => $adminId,
                    'created_at' => $date->copy()->addHours(rand(14, 18)),
                ]);
            }
        }

        // Create 30 expenses over the past 14 days
        for ($i = 0; $i < 30; $i++) {
            $daysAgo = rand(0, 13);
            $date = Carbon::today()->subDays($daysAgo);
            $kategori = $expenseCategories[array_rand($expenseCategories)];

            $nominal = match (true) {
                str_contains($kategori, 'BBM') => rand(100, 500) * 1000,
                str_contains($kategori, 'Makan') => rand(30, 80) * 1000,
                str_contains($kategori, 'Tol') => rand(20, 100) * 1000,
                str_contains($kategori, 'Perawatan') => rand(200, 1000) * 1000,
                str_contains($kategori, 'Listrik') => rand(500, 2000) * 1000,
                default => rand(10, 100) * 1000,
            };

            $keteranganMap = [
                'BBM / Solar' => ['Solar armada truk CJR-01', 'Solar armada truk CJR-02', 'BBM kendaraan operasional'],
                'BBM / Bensin' => ['Bensin motor kurir', 'Bensin kendaraan pick-up'],
                'Makan Supir' => ['Uang makan supir rute Bandung', 'Uang makan supir rute Jakarta'],
                'Tol' => ['Tol Cipularang', 'Tol Cikopo-Palimanan', 'Tol Jakarta-Cikampek'],
                'Perawatan Armada' => ['Ganti oli truk', 'Servis rutin armada', 'Ganti ban'],
                'ATK & Kantor' => ['Kertas printer', 'Tinta printer', 'Alat tulis'],
                'Listrik & Air' => ['Tagihan listrik bulanan', 'Tagihan air'],
                'Lain-lain' => ['Biaya parkir', 'Biaya bongkar muat'],
            ];

            $keteranganOptions = $keteranganMap[$kategori] ?? ['Operasional harian'];

            Expense::create([
                'tanggal' => $date->toDateString(),
                'kategori' => $kategori,
                'nominal' => $nominal,
                'keterangan' => $keteranganOptions[array_rand($keteranganOptions)],
                'user_id' => $adminId,
                'created_at' => $date->copy()->addHours(rand(8, 16)),
            ]);
        }

        // Create 5 misc incomes
        for ($i = 0; $i < 5; $i++) {
            $daysAgo = rand(0, 13);
            $date = Carbon::today()->subDays($daysAgo);

            Income::create([
                'tanggal' => $date->toDateString(),
                'sumber' => 'lainnya',
                'nominal' => rand(50, 500) * 1000,
                'keterangan' => collect(['Jasa packing tambahan', 'Biaya asuransi barang', 'Denda keterlambatan pickup', 'Jasa sewa gudang', 'Pembayaran COD'])->random(),
                'user_id' => $adminId,
                'created_at' => $date->copy()->addHours(rand(9, 15)),
            ]);
        }
    }
}
