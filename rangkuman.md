# Rangkuman Teknis Aplikasi In-TrackFin
> Dokumen ini dibuat sebagai bahan laporan Kerja Praktek.

---

## 1. Gambaran Umum Aplikasi

**In-TrackFin** adalah aplikasi web operasional internal berbasis *web* yang dikembangkan untuk memfasilitasi kebutuhan administrasi **PT Indah Logistik Cabang Cianjur**. Aplikasi ini mengintegrasikan dua fungsi utama dalam satu platform:

1. **Shipment Tracking** — Mengelola dan memonitor siklus pengiriman barang dari penerimaan paket di cabang hingga selesai dikirimkan ke tujuan.
2. **Financial Management** — Mencatat seluruh arus kas masuk (*income*) dan arus kas keluar (*expense*) operasional cabang secara real-time.

Aplikasi dirancang dengan antarmuka modern menggunakan tema *Dark Mode* dan estetika *Glassmorphism*, serta bersifat *responsive* sehingga dapat diakses dari berbagai perangkat.

---

## 2. Stack Teknologi

### Backend
| Komponen | Teknologi | Versi |
|---|---|---|
| Bahasa Pemrograman | PHP | ^8.2 |
| Framework Backend | Laravel | ^12.0 |
| REPL / Debugging | Laravel Tinker | ^2.10.1 |
| Autentikasi & Scaffolding | Laravel Breeze | ^2.4 |
| Generator PDF | barryvdh/laravel-dompdf | ^3.1 |
| Testing Framework | Pest PHP | * (latest) |
| Pest Plugin | pest-plugin-laravel | * (latest) |

### Frontend
| Komponen | Teknologi | Versi |
|---|---|---|
| CSS Framework | Tailwind CSS | ^4.2.1 |
| JavaScript Interaktif | Alpine.js | ^3.4.2 |
| HTTP Client (AJAX) | Axios | ^1.11.0 |
| Build Tool / Bundler | Vite | ^7.0.7 |
| Integrasi Laravel-Vite | laravel-vite-plugin | ^2.0.0 |
| Tailwind Plugin (Vite) | @tailwindcss/vite | ^4.0.0 |

### Database & Lingkungan Server
| Komponen | Teknologi |
|---|---|
| Database | MySQL |
| Database Name | `intrackfindb` |
| Local Development Server | Laravel Herd |
| App URL (Development) | `http://in-trackfin.test` |
| Session Storage | Database |
| Cache Storage | Database |
| Queue Driver | Database |

---

## 3. Arsitektur Aplikasi

Aplikasi dibangun mengikuti pola arsitektur **MVC (Model-View-Controller)** bawaan Laravel dengan tambahan komponen middleware untuk keamanan.

```
in-trackfin/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Logika bisnis aplikasi
│   │   │   ├── DashboardController.php
│   │   │   ├── ResiController.php
│   │   │   ├── IncomeController.php
│   │   │   ├── ExpenseController.php
│   │   │   ├── ReportController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php   # Custom middleware RBAC
│   │   └── Requests/           # Form Request Validation
│   └── Models/                 # Eloquent ORM Models
│       ├── User.php
│       ├── Resi.php
│       ├── Income.php
│       └── Expense.php
├── database/
│   └── migrations/             # Skema database (6 file migrasi)
├── resources/
│   ├── views/                  # Blade Template Engine
│   │   ├── layouts/            # Master layout
│   │   ├── components/         # Komponen UI reusable
│   │   ├── resi/
│   │   ├── incomes/
│   │   ├── expenses/
│   │   └── reports/
│   ├── css/app.css             # Entry point CSS (Tailwind)
│   └── js/app.js               # Entry point JavaScript (Alpine.js + Axios)
├── routes/
│   ├── web.php                 # Definisi rute aplikasi web
│   └── auth.php                # Rute autentikasi (dari Laravel Breeze)
├── vite.config.js              # Konfigurasi Vite & Tailwind
└── composer.json               # Dependensi PHP (Composer)
```

---

## 4. Fitur Utama

### 4.1 Autentikasi & Manajemen Akses (RBAC)
- Sistem login aman menggunakan **Laravel Breeze** dengan hashing password bcrypt (12 *rounds*).
- Dua tingkatan hak akses (*Role-Based Access Control*):
  - **Admin Cabang (`admin`)**: Input data resi, update status, catat transaksi keuangan.
  - **Kepala Cabang (`kepala_cabang`)**: Akses penuh, fokus pada pemantauan dashboard dan laporan laba rugi.
- Custom middleware `CheckRole.php` untuk penjagaan rute berbasis peran.

### 4.2 Dashboard Interaktif
- Menampilkan **kartu metrik harian**: Total Resi, Total Pemasukan, Total Pengeluaran.
- Grafik visual status pengiriman dan rangkuman arus kas.
- Data diambil dan diproses langsung dari controller (`DashboardController`).

### 4.3 Tracking Resi (Manajemen Pengiriman)
- CRUD data resi pengiriman dengan format nomor unik otomatis: `CJR-YYYYMMDD-XXXX`.
- Pembaruan status resi secara bertahap: `tiba_di_cabang` → `sedang_diproses` → `dibawa_kurir` → `selesai`.
- **Integrasi Finansial Otomatis**: Saat resi baru dibuat, sistem secara otomatis menghasilkan catatan *Income* yang terhubung via *foreign key* `resi_id`.

### 4.4 Manajemen Keuangan
- **Modul Pemasukan (Income)**: Mencatat arus kas masuk, baik yang dihasilkan otomatis dari resi maupun input manual.
- **Modul Pengeluaran (Expense)**: Mencatat arus kas keluar dengan kategorisasi (Operasional, BBM, Gaji, dll.).

### 4.5 Laporan Laba Rugi
- Filter laporan berdasarkan rentang tanggal atau bulan.
- Menghitung selisih total pemasukan dan pengeluaran (Profit / Defisit).
- **Ekspor Laporan** dalam dua format:
  - **PDF** — menggunakan library `barryvdh/laravel-dompdf`.
  - **Excel** — melalui rute `reports/export-excel`.

---

## 5. Struktur Database

Aplikasi menggunakan **6 tabel utama** yang dikelola melalui sistem migrasi Laravel:

| Tabel | Deskripsi |
|---|---|
| `users` | Data pengguna dan peran (role) |
| `resi` | Data resi/pengiriman paket |
| `incomes` | Catatan arus kas masuk |
| `expenses` | Catatan arus kas keluar |
| `cache` | Penyimpanan cache berbasis database |
| `jobs` | Antrean pekerjaan (Queue) berbasis database |

**Relasi Utama Antar Tabel:**
- `USERS` → `RESI`: One-to-Many (satu user bisa membuat banyak resi)
- `USERS` → `INCOMES`: One-to-Many
- `USERS` → `EXPENSES`: One-to-Many
- `RESI` → `INCOMES`: One-to-One (satu resi menghasilkan tepat satu catatan pemasukan)

---

## 6. Tools & Lingkungan Pengembangan

| Tool | Fungsi |
|---|---|
| **Laravel Herd** | Server pengembangan lokal di Windows |
| **Composer** | Package manager untuk dependensi PHP |
| **npm** | Package manager untuk dependensi JavaScript/Node.js |
| **Vite** | Build tool untuk kompilasi dan hot-reloading aset frontend |
| **Laravel Pint** | Code formatter PHP otomatis (standar PSR-12) |
| **Laravel Pail** | Log viewer interaktif di terminal |
| **Laravel Sail** | Alternatif environment berbasis Docker |
| **Pest PHP** | Framework pengujian (testing) modern untuk PHP |
| **Faker PHP** | Pembuatan data palsu untuk keperluan seeding/testing |
| **Mockery** | Library untuk membuat mock objects saat unit testing |

---

## 7. Pola & Konsep Pengembangan yang Diterapkan

- **MVC (Model-View-Controller)**: Pemisahan jelas antara logika data, tampilan, dan logika bisnis.
- **Eloquent ORM**: Interaksi dengan database menggunakan Object-Relational Mapping Laravel.
- **Blade Templating Engine**: Sistem template bawaan Laravel untuk tampilan yang modular dan reusable.
- **RESTful Resource Routing**: Pendefinisian rute mengikuti konvensi REST (`Route::resource()`).
- **Form Request Validation**: Validasi input form dipisahkan ke kelas tersendiri di direktori `Requests/`.
- **Database Migration**: Pengelolaan skema database melalui kode yang version-controlled.
- **Database Seeding**: Pengisian data awal melalui Seeder.
- **RBAC (Role-Based Access Control)**: Sistem hak akses berbasis peran dengan middleware kustom.
- **Lokalisasi**: Aplikasi dikonfigurasi dengan `APP_LOCALE=id` untuk mendukung Bahasa Indonesia.
