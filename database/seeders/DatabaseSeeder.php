<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Motivation;
use App\Models\Position;
use App\Models\Setting;
use App\Models\WorkShift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Settings
        $settings = [
            ['key' => 'jam_masuk', 'value' => '08:00', 'group' => 'jam_kerja', 'keterangan' => 'Jam masuk normal'],
            ['key' => 'jam_keluar', 'value' => '17:00', 'group' => 'jam_kerja', 'keterangan' => 'Jam keluar normal'],
            ['key' => 'toleransi_terlambat', 'value' => '15', 'group' => 'jam_kerja', 'keterangan' => 'Toleransi terlambat (menit)'],
            ['key' => 'jatah_cuti_tahunan', 'value' => '12', 'group' => 'cuti', 'keterangan' => 'Jatah cuti tahunan (hari)'],
            ['key' => 'metode_perhitungan_cuti', 'value' => 'calendar_year', 'group' => 'cuti', 'keterangan' => 'Metode: calendar_year / anniversary'],
            ['key' => 'grace_period_bulan', 'value' => '6', 'group' => 'cuti', 'keterangan' => 'Grace period cuti (bulan)'],
            ['key' => 'allow_carry_over', 'value' => '0', 'group' => 'cuti', 'keterangan' => 'Izinkan carry over cuti: 1=ya, 0=tidak'],
            ['key' => 'max_carry_over', 'value' => '5', 'group' => 'cuti', 'keterangan' => 'Maksimal carry over (hari)'],
            ['key' => 'min_masa_kerja_cuti', 'value' => '12', 'group' => 'cuti', 'keterangan' => 'Minimal masa kerja untuk dapat cuti (bulan)'],
            ['key' => 'nama_perusahaan', 'value' => 'PT. Maju Bersama', 'group' => 'umum', 'keterangan' => 'Nama perusahaan'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        // Work Shifts
        $shifts = [
            ['nama' => 'Normal', 'jam_masuk' => '08:00', 'jam_keluar' => '17:00', 'toleransi_terlambat_menit' => 15],
            ['nama' => 'Pagi', 'jam_masuk' => '06:00', 'jam_keluar' => '14:00', 'toleransi_terlambat_menit' => 15],
            ['nama' => 'Siang', 'jam_masuk' => '14:00', 'jam_keluar' => '22:00', 'toleransi_terlambat_menit' => 15],
            ['nama' => 'Malam', 'jam_masuk' => '22:00', 'jam_keluar' => '06:00', 'toleransi_terlambat_menit' => 15],
        ];

        foreach ($shifts as $shift) {
            WorkShift::create($shift);
        }

        // Departments
        $departments = [
            ['nama' => 'IT', 'kode' => 'IT'],
            ['nama' => 'HRD', 'kode' => 'HRD'],
            ['nama' => 'Finance', 'kode' => 'FIN'],
            ['nama' => 'Marketing', 'kode' => 'MKT'],
            ['nama' => 'Produksi', 'kode' => 'PRD'],
            ['nama' => 'General Affair', 'kode' => 'GA'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Positions
        $positions = [
            ['nama' => 'Staff', 'level' => 1],
            ['nama' => 'Senior Staff', 'level' => 2],
            ['nama' => 'Supervisor', 'level' => 3],
            ['nama' => 'Assistant Manager', 'level' => 4],
            ['nama' => 'Manager', 'level' => 5],
            ['nama' => 'Senior Manager', 'level' => 6],
            ['nama' => 'Director', 'level' => 7],
        ];

        foreach ($positions as $pos) {
            Position::create($pos);
        }

        // Leave Types
        $leaveTypes = [
            ['nama' => 'Cuti Tahunan', 'jatah_hari' => 12, 'potong_cuti' => true],
            ['nama' => 'Cuti Sakit', 'jatah_hari' => 14, 'potong_cuti' => false],
            ['nama' => 'Cuti Melahirkan', 'jatah_hari' => 90, 'potong_cuti' => false],
            ['nama' => 'Cuti Menikah', 'jatah_hari' => 3, 'potong_cuti' => false],
            ['nama' => 'Cuti Kematian Keluarga', 'jatah_hari' => 2, 'potong_cuti' => false],
            ['nama' => 'Cuti Khitan/Baptis Anak', 'jatah_hari' => 2, 'potong_cuti' => false],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create($type);
        }

        // Admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama' => 'Administrator',
            'role' => 'superadmin',
        ]);

        Admin::create([
            'username' => 'hr',
            'password' => Hash::make('hr123'),
            'nama' => 'HRD Staff',
            'role' => 'hr',
        ]);

        // Sample Employees
        $normalShift = WorkShift::where('nama', 'Normal')->first();
        $itDept = Department::where('kode', 'IT')->first();
        $hrdDept = Department::where('kode', 'HRD')->first();
        $finDept = Department::where('kode', 'FIN')->first();
        $staffPos = Position::where('nama', 'Staff')->first();
        $supervisorPos = Position::where('nama', 'Supervisor')->first();
        $managerPos = Position::where('nama', 'Manager')->first();

        $employees = [
            [
                'nik' => '001',
                'pin' => Hash::make('123456'),
                'nama_lengkap' => 'Ahmad Fauzi',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-05-15',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'no_hp' => '081234567890',
                'email' => 'ahmad@company.com',
                'department_id' => $itDept->id,
                'position_id' => $managerPos->id,
                'work_shift_id' => $normalShift->id,
                'tanggal_masuk' => '2020-01-15',
                'status_karyawan' => 'tetap',
            ],
            [
                'nik' => '002',
                'pin' => Hash::make('123456'),
                'nama_lengkap' => 'Siti Aminah',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1992-08-20',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'no_hp' => '081234567891',
                'email' => 'siti@company.com',
                'department_id' => $finDept->id,
                'position_id' => $supervisorPos->id,
                'work_shift_id' => $normalShift->id,
                'tanggal_masuk' => '2021-03-01',
                'status_karyawan' => 'tetap',
            ],
            [
                'nik' => '003',
                'pin' => Hash::make('123456'),
                'nama_lengkap' => 'Budi Santoso',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1995-12-10',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'no_hp' => '081234567892',
                'email' => 'budi@company.com',
                'department_id' => $itDept->id,
                'position_id' => $staffPos->id,
                'work_shift_id' => $normalShift->id,
                'tanggal_masuk' => '2022-06-01',
                'status_karyawan' => 'tetap',
                'atasan_id' => 1,
            ],
            [
                'nik' => '004',
                'pin' => Hash::make('123456'),
                'nama_lengkap' => 'Dewi Lestari',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1993-03-25',
                'jenis_kelamin' => 'P',
                'agama' => 'Kristen',
                'no_hp' => '081234567893',
                'email' => 'dewi@company.com',
                'department_id' => $hrdDept->id,
                'position_id' => $staffPos->id,
                'work_shift_id' => $normalShift->id,
                'tanggal_masuk' => '2023-01-10',
                'status_karyawan' => 'kontrak',
            ],
            [
                'nik' => '005',
                'pin' => Hash::make('123456'),
                'nama_lengkap' => 'Rudi Hermawan',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1988-07-30',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'no_hp' => '081234567894',
                'email' => 'rudi@company.com',
                'department_id' => $itDept->id,
                'position_id' => $staffPos->id,
                'work_shift_id' => $normalShift->id,
                'tanggal_masuk' => '2021-09-15',
                'status_karyawan' => 'tetap',
                'atasan_id' => 1,
            ],
        ];

        foreach ($employees as $emp) {
            Employee::create($emp);
        }

        // Leave Balances for current year
        $cutiTahunan = LeaveType::where('nama', 'Cuti Tahunan')->first();
        $currentYear = now()->year;

        foreach (Employee::all() as $employee) {
            LeaveBalance::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $cutiTahunan->id,
                'tahun' => $currentYear,
                'jatah' => 12,
                'terpakai' => 0,
                'sisa' => 12,
            ]);
        }

        // Motivations - Masuk
        $motivasiMasuk = [
            ['tipe' => 'masuk', 'kategori' => 'umum', 'pesan' => 'Setiap hari adalah halaman baru. Tulis cerita terbaikmu hari ini!', 'gif_url' => 'https://media.giphy.com/media/3o7abKhOpu0NwenH3O/giphy.gif'],
            ['tipe' => 'masuk', 'kategori' => 'umum', 'pesan' => 'Kerja keras hari ini adalah investasi untuk masa depan yang lebih cerah!', 'gif_url' => 'https://media.giphy.com/media/l0MYt5jPR6QX5APm0/giphy.gif'],
            ['tipe' => 'masuk', 'kategori' => 'pagi', 'pesan' => 'Pagi yang indah dimulai dari langkah pertama. Kamu sudah di sini, itu luar biasa!', 'gif_url' => 'https://media.giphy.com/media/xT5LMHxhOfscxPfIfm/giphy.gif'],
            ['tipe' => 'masuk', 'kategori' => 'senin', 'pesan' => 'Senin bukan beban, tapi awal dari pencapaian baru minggu ini! Semangat!', 'gif_url' => 'https://media.giphy.com/media/3o7abKhOpu0NwenH3O/giphy.gif'],
            ['tipe' => 'masuk', 'kategori' => 'jumat', 'pesan' => 'Happy Friday! Satu hari lagi menuju weekend. Finish strong!', 'gif_url' => 'https://media.giphy.com/media/l0MYt5jPR6QX5APm0/giphy.gif'],
            ['tipe' => 'masuk', 'kategori' => 'umum', 'pesan' => 'Kamu adalah bagian penting dari tim ini. Terima kasih sudah hadir hari ini!', 'gif_url' => 'https://media.giphy.com/media/26u4cqiYI30juCOGY/giphy.gif'],
            ['tipe' => 'masuk', 'kategori' => 'umum', 'pesan' => 'Sukses tidak datang dari apa yang kamu lakukan sesekali, tapi dari yang kamu lakukan konsisten!', 'gif_url' => 'https://media.giphy.com/media/xT5LMHxhOfscxPfIfm/giphy.gif'],
        ];

        // Motivations - Pulang
        $motivasiPulang = [
            ['tipe' => 'pulang', 'kategori' => 'umum', 'pesan' => 'Terima kasih atas dedikasi hari ini. Kamu hebat! Istirahat yang cukup ya.', 'gif_url' => 'https://media.giphy.com/media/3o7abGQa0aRJUurpII/giphy.gif'],
            ['tipe' => 'pulang', 'kategori' => 'umum', 'pesan' => 'Kerja keras hari ini tidak akan sia-sia. Sampai jumpa besok!', 'gif_url' => 'https://media.giphy.com/media/l3q2wJsC23ikJg9xe/giphy.gif'],
            ['tipe' => 'pulang', 'kategori' => 'umum', 'pesan' => 'Istirahat adalah bagian dari produktivitas. Nikmati waktumu!', 'gif_url' => 'https://media.giphy.com/media/3o7abGQa0aRJUurpII/giphy.gif'],
            ['tipe' => 'pulang', 'kategori' => 'jumat', 'pesan' => 'Weekend sudah menanti! Nikmati istirahatmu, kamu layak mendapatkannya.', 'gif_url' => 'https://media.giphy.com/media/l3q2wJsC23ikJg9xe/giphy.gif'],
            ['tipe' => 'pulang', 'kategori' => 'lembur', 'pesan' => 'Pulang lebih malam menunjukkan tanggung jawabmu yang besar. Salut! Hati-hati di jalan.', 'gif_url' => 'https://media.giphy.com/media/3o7abGQa0aRJUurpII/giphy.gif'],
            ['tipe' => 'pulang', 'kategori' => 'umum', 'pesan' => 'Hari ini sudah kamu lewati dengan baik. Besok pasti lebih baik lagi!', 'gif_url' => 'https://media.giphy.com/media/l3q2wJsC23ikJg9xe/giphy.gif'],
        ];

        foreach (array_merge($motivasiMasuk, $motivasiPulang) as $motivasi) {
            Motivation::create($motivasi);
        }

        // Holidays 2026
        $holidays = [
            ['tanggal' => '2026-01-01', 'nama' => 'Tahun Baru 2026', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-01-29', 'nama' => 'Tahun Baru Imlek', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-03-20', 'nama' => 'Hari Raya Nyepi', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-03-29', 'nama' => 'Isra Miraj', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-04-03', 'nama' => 'Wafat Isa Almasih', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-05-01', 'nama' => 'Hari Buruh', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-05-14', 'nama' => 'Kenaikan Isa Almasih', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-06-01', 'nama' => 'Hari Lahir Pancasila', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-08-17', 'nama' => 'Hari Kemerdekaan RI', 'tipe' => 'nasional', 'tahun' => 2026],
            ['tanggal' => '2026-12-25', 'nama' => 'Hari Natal', 'tipe' => 'nasional', 'tahun' => 2026],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }
}
