# TestSprite AI Testing Report (MCP)

---

## 1-Document Metadata

| Field | Detail |
|-------|--------|
| **Project Name** | In-TrackFin |
| **Module Tested** | Autentikasi (TC-AU-01 sampai TC-AU-06) |
| **Date** | 2026-10-16 |
| **Prepared by** | TestSprite AI via MCP + Antigravity |
| **Test Type** | Frontend End-to-End Browser Automation |
| **App URL** | http://in-trackfin.test (Laravel Herd) |
| **Framework** | Laravel 11 + Breeze (Blade Templates) |
| **Test Session** | f4245d9e-67e6-5727-918e-b66ecbb81fac |

---

## 2-Requirement Validation Summary

### REQ-AU: Autentikasi Pengguna

#### TC-AU-01 (TC001/TC002) - Login akun valid -> dashboard
- **Status:** FAILED (Run 1) - Root cause: password test salah, FIXED
- **Observasi:** Red error alert auth.failed tampil. Page tetap di /login.
- **Analisis:** Aplikasi berjalan benar. Data uji password tidak match hash DB. Password direset ke TestPass123!
- **Visualization:** https://www.testsprite.com/dashboard/mcp/tests/f4245d9e-67e6-5727-918e-b66ecbb81fac/test/82514cd1-323e-4bb4-8222-e0aea87c9624

#### TC-AU-02 (TC004) - Email salah -> error message
- **Status:** BLOCKED - Tunnel DNS tidak bisa resolve in-trackfin.test
- **Visualization:** https://www.testsprite.com/dashboard/mcp/tests/f4245d9e-67e6-5727-918e-b66ecbb81fac/test/9ba93c02-9717-4778-af38-0eda787faa08

#### TC-AU-03 (TC004) - Password salah -> error message
- **Status:** BLOCKED - Tunnel DNS issue
- **Catatan:** Run pertama menunjukkan auth.failed ditampilkan (bukan teks lengkap) - kemungkinan key lokalisasi belum diset

#### TC-AU-04 (TC007) - Email kosong -> validasi
- **Status:** BLOCKED - Tunnel DNS issue
- **Visualization:** https://www.testsprite.com/dashboard/mcp/tests/f4245d9e-67e6-5727-918e-b66ecbb81fac/test/4bf4f6c4-734e-4c14-81ec-1cf74313d830

#### TC-AU-05 (TC008) - Password kosong -> validasi
- **Status:** BLOCKED - Tunnel DNS issue
- **Visualization:** https://www.testsprite.com/dashboard/mcp/tests/f4245d9e-67e6-5727-918e-b66ecbb81fac/test/b5f68fe8-72a3-4e82-bd88-5d78a2cd7026

#### TC-AU-06 (TC006) - Logout -> kembali login
- **Status:** BLOCKED - Tunnel DNS issue (tidak bisa login dulu)
- **Visualization:** https://www.testsprite.com/dashboard/mcp/tests/f4245d9e-67e6-5727-918e-b66ecbb81fac/test/9cd2df24-8ec9-4249-841b-f046d55d6e6c

---

## 3-Coverage and Matching Metrics

| Requirement | Total | Passed | Failed | Blocked |
|-------------|-------|--------|--------|---------|
| REQ-AU: Autentikasi | 6 | 0 | 1 | 5 |
| REQ-SESSION: Sesi | 1 | 0 | 0 | 1 |
| REQ-DASHBOARD: Dashboard | 1 | 0 | 0 | 1 |
| TOTAL | 8 | 0 | 1 | 7 |

Coverage: 12.5% (1 dieksekusi dari 8 test) - blocked karena infrastruktur

---

## 4-Key Gaps Risks

### CRITICAL: Virtual Host DNS Incompatibility
- Root cause: in-trackfin.test hanya ada di Windows hosts file lokal
- TestSprite cloud runner tidak bisa resolve nama domain ini
- Fix: jalankan php artisan serve di port standar, atau gunakan ngrok

### BUG: Pesan auth.failed tampil sebagai lokalisasi key
- Observasi: pesan "auth.failed" bukan "These credentials do not match our records"
- Fix: verifikasi lang/id/auth.php memiliki key failed yang benar

### DATA: Password test tidak diketahui (RESOLVED)
- Status: FIXED - Password direset ke TestPass123! via artisan tinker
- Rekomendasi: buat DatabaseSeeder khusus untuk test environment
