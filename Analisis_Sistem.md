# 4.1 Analisis Sistem

## 4.1.1 Analisis Sistem Berjalan
Pada proses operasional yang sedang berjalan (sebelum digitalisasi terintegrasi), pencatatan keuangan dan alur penelusuran pengiriman di Indah Logistik Cabang Cianjur umumnya masih dikelola secara terpisah atau semi-manual. 
1. **Penelusuran Pengiriman (Tracking):** Pembaruan status pengiriman paket seringkali dicatat melalui dokumen manifest fisik atau aplikasi pencatatan sederhana yang terpisah, sehingga pembaruan informasi terkadang tidak *real-time* dan menyulitkan pemantauan secara berkesinambungan.
2. **Pencatatan Keuangan:** Proses pencatatan pendapatan dari ongkos kirim (berdasarkan resi) dan pengeluaran operasional (seperti BBM armada, biaya perawatan, dsb.) dikerjakan secara manual melalui buku kas atau spreadsheet. Hal ini dapat memicu masalah seperti rentannya *human error*, duplikasi data, atau keterlambatan penyusunan laporan Laba/Rugi operasional cabang.

Dengan sistem terintegrasi yang telah dibangun, pencatatan ini direformasi; satu tindakan pembuatan resi akan secara logis menghasilkan pembaruan informasi *tracking* sekaligus pencatatan pendapatan finansial secara otomatis (sistem satu pintu).

## 4.1.2 Analisis Kebutuhan Sistem

### 4.1.2.1 Kebutuhan Fungsional
Kebutuhan fungsional mendefinisikan fitur-fitur dan proses utama yang wajib difasilitasi oleh sistem yang dibuat:
1. **Manajemen Pembuatan Resi:** Sistem harus mampu mencatat, menyimpan, dan meng-*generate* nomor resi unik secara otomatis saat staf memasukkan data pengiriman barang.
2. **Pencatatan Transaksi Pemasukan Otomatis:** Sistem harus mencatat nominal ongkos kirim pada setiap resi baru sebagai pendapatan operasional (Income) secara otomatis ke dalam arus kas cabang.
3. **Pencatatan Pengeluaran Operasional:** Sistem harus menyediakan fitur (*form*) bagi staf untuk mencatat biaya pengeluaran operasional (Expense) seperti bensin, gaji, perawatan kendaraan, dengan klasifikasi kategorinya.
4. **Penelusuran (Tracking) Resi Pengiriman:** Sistem wajib menyediakan antarmuka bagi staf untuk memperbarui riwayat dan status pengiriman (misal: *Dalam Proses*, *Sedang Dikirim*, *Selesai*) untuk memudahkan pencarian data internal ketika pelanggan menanyakan status paketnya.
5. **Dashboard dan Laporan Keuangan:** Sistem harus mampu menyajikan rekapitulasi data total resi, pemasukan, pengeluaran, dan menyusun Laporan Laba/Rugi (*Profit/Loss*) berdasarkan periode tertentu untuk manajemen.
6. **Manajemen Autentikasi:** Sistem harus bisa melakukan verifikasi login pengguna dan membatasi akses sesuai dengan tingkatan jabatannya.

### 4.1.2.2 Kebutuhan Non-Fungsional
Kebutuhan non-fungsional menjelaskan spesifikasi performa, kelayakan teknis, keamanan, dan keandalan sistem agar berjalan stabil:
1. **Keamanan Data (Security):** 
   - Akses pengubahan data keuangan hanya diizinkan untuk pengguna berstatus *login* dengan *role* yang sesuai.
   - Kata sandi (*password*) pengguna pada basis data harus dilindungi dengan enkripsi/hashing standar industri (misal: *Bcrypt*).
2. **Performa (Performance):** 
   - Halaman utama (dashboard) dan penelusuran resi harus dimuat dalam waktu kurang dari 3 detik meski sistem menyimpan ribuan data riwayat (*history*) tracking.
3. **Keandalan (Reliability) dan Ketersediaan (Availability):** 
   - Sistem dirancang berbasis *web-based application* (Laravel) agar dapat dikelola dan diakses secara terpusat selama 24/7.
4. **Usability (Kemudahan Penggunaan):** 
   - Antarmuka (*User Interface*) harus dirancang efisien dan se-intuitif mungkin (mendukung *mobile-responsive* minimal) karena staf cabang membutuhkan kecepatan tinggi dalam proses pendataan saat menerima banyak paket dari klien.

## 4.1.3 Analisis Pengguna dan Hak Akses
Sistem ini didesain eksklusif untuk operasional internal dengan memetakan kebutuhan dari 2 entitas pengguna utama. Hak akses (otorisasi) dipisah secara jelas untuk menjaga validitas data:

1. **Admin / Kepala Cabang:**
   - Memiliki wewenang hak akses tertinggi (*Super/Master Access*).
   - Dapat mengelola data pengguna aplikasi (menambah atau menghapus akun staf operasional).
   - Memiliki hak untuk meninjau secara komprehensif seluruh catatan Laporan Keuangan (Laba/Rugi), dasbor metrik pengiriman harian, dan ringkasan arus kas cabang untuk kebutuhan pengambilan keputusan (*decision making*).

2. **Kasir / Staf Keuangan dan Operasional:**
   - Berperan sebagai penggerak aktivitas operasional harian.
   - Diberi hak akses untuk menambah data resi baru (yang secara otomatis tercatat menjadi pemasukan keuangan).
   - Memiliki tanggung jawab dan akses untuk mencatat data pengeluaran harian operasional (*expenses*).
   - Dapat melakukan pembaruan status pelacakan paket (*update tracking*).
   - Bertugas melayani pencarian resi dari dalam sistem apabila ada pelanggan yang menanyakan status pengirimannya.

*(Catatan: **Pelanggan** bertindak pasif di luar sistem dan tidak memiliki akses langsung. Segala alur pelayanan seperti pembuatan resi hingga pelacakan paket dilakukan melalui perantara Staf/Kasir).*
