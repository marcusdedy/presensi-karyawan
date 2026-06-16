# Aplikasi Presensi Karyawan

Aplikasi presensi karyawan berbasis web menggunakan Laravel 11, dilengkapi dengan fitur cuti online, izin terlambat/pulang cepat, lembur, dan manajemen data karyawan.

## Fitur Utama

- **Presensi via PIN** - Halaman publik, tanpa login, cukup input PIN
- **Pop Up Motivasi + GIF** - Kata-kata penyemangat setelah absen masuk/pulang
- **Cuti Online** - Pengajuan, approval, sisa cuti configurable
- **Izin Datang Terlambat** - Permohonan + approval + integrasi presensi
- **Izin Pulang Cepat** - Permohonan + approval + integrasi presensi
- **Lembur** - Pengajuan & rekap jam lembur (tanpa payroll)
- **Profil Karyawan Lengkap** - Master data karyawan
- **Riwayat Karir** - Timeline promosi, mutasi, perubahan status
- **Shift Kerja** - Multi-shift + jadwal shift per karyawan
- **Dashboard Admin** - Statistik kehadiran + grafik
- **Laporan** - Kehadiran, cuti, lembur per departemen
- **Approval System** - Cuti, izin, lembur
- **Pengaturan** - Jam kerja, hari libur, motivasi (configurable)

## Autentikasi

| Halaman | URL | Metode |
|---------|-----|--------|
| Absen (Publik) | `/absen` | Input PIN saja |
| Panel Karyawan | `/karyawan/login` | NIK + PIN |
| Panel Admin | `/admin/login` | Username + Password |

## Tech Stack

- PHP 8.2+
- Laravel 11
- SQLite / MySQL / PostgreSQL
- Bootstrap 5.3 + Bootstrap Icons
- SweetAlert2 (pop up motivasi)

## Instalasi

```bash
# Clone repository
git clone https://github.com/marcusdedy/presensi-karyawan.git
cd presensi-karyawan

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Buat file database (jika pakai SQLite)
touch database/database.sqlite

# Jalankan migration dan seeder
php artisan migrate --seed

# Jalankan aplikasi
php artisan serve
```

## Akses Default (Setelah Seeder)

### Admin
- Username: `admin`
- Password: `admin123`

### Karyawan (Sample)
- NIK: `001`, PIN: `111111` (Ahmad Fauzi)
- NIK: `002`, PIN: `222222` (Siti Aminah)
- NIK: `003`, PIN: `333333` (Budi Santoso)
- NIK: `004`, PIN: `444444` (Dewi Lestari)
- NIK: `005`, PIN: `555555` (Rudi Hermawan)

## Struktur Database

- `employees` - Data karyawan lengkap
- `departments` - Departemen
- `positions` - Jabatan
- `work_shifts` - Master shift kerja
- `employee_shifts` - Jadwal shift per karyawan
- `attendances` - Data presensi harian
- `leave_types` - Jenis cuti
- `leave_requests` - Pengajuan cuti
- `leave_balances` - Saldo cuti per tahun
- `permission_requests` - Izin terlambat / pulang cepat
- `overtime_requests` - Pengajuan lembur
- `career_histories` - Riwayat karir
- `motivations` - Kata motivasi + GIF
- `holidays` - Hari libur
- `settings` - Pengaturan sistem
- `admins` - Data admin

## Lisensi

MIT License
