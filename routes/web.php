<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Employee;
use Illuminate\Support\Facades\Route;

// Home - redirect to absen
Route::get('/', function () {
    return redirect()->route('absen.index');
});

// ===== PUBLIC: ABSEN (Tanpa Login) =====
Route::prefix('absen')->group(function () {
    Route::get('/', [AbsenController::class, 'index'])->name('absen.index');
    Route::post('/verify', [AbsenController::class, 'verify'])->name('absen.verify');
    Route::post('/store', [AbsenController::class, 'store'])->name('absen.store');
});

// ===== EMPLOYEE AUTH =====
Route::prefix('karyawan')->group(function () {
    Route::get('/login', [Employee\AuthController::class, 'showLogin'])->name('employee.login');
    Route::post('/login', [Employee\AuthController::class, 'login'])->name('employee.login.submit');
    Route::post('/logout', [Employee\AuthController::class, 'logout'])->name('employee.logout');
});

// ===== EMPLOYEE PANEL (Auth Required) =====
Route::prefix('karyawan')->middleware(\App\Http\Middleware\EmployeeAuth::class)->group(function () {
    Route::get('/dashboard', [Employee\DashboardController::class, 'index'])->name('employee.dashboard');

    // Rekap Presensi
    Route::get('/presensi', [Employee\AttendanceController::class, 'index'])->name('employee.attendance.index');

    // Cuti
    Route::get('/cuti', [Employee\LeaveController::class, 'index'])->name('employee.leave.index');
    Route::get('/cuti/ajukan', [Employee\LeaveController::class, 'create'])->name('employee.leave.create');
    Route::post('/cuti', [Employee\LeaveController::class, 'store'])->name('employee.leave.store');
    Route::get('/cuti/sisa', [Employee\LeaveController::class, 'balance'])->name('employee.leave.balance');

    // Izin (Terlambat / Pulang Cepat)
    Route::get('/izin', [Employee\PermissionController::class, 'index'])->name('employee.permission.index');
    Route::get('/izin/ajukan', [Employee\PermissionController::class, 'create'])->name('employee.permission.create');
    Route::post('/izin', [Employee\PermissionController::class, 'store'])->name('employee.permission.store');

    // Lembur
    Route::get('/lembur', [Employee\OvertimeController::class, 'index'])->name('employee.overtime.index');
    Route::get('/lembur/ajukan', [Employee\OvertimeController::class, 'create'])->name('employee.overtime.create');
    Route::post('/lembur', [Employee\OvertimeController::class, 'store'])->name('employee.overtime.store');

    // Profil & Karir
    Route::get('/profil', [Employee\ProfileController::class, 'index'])->name('employee.profile.index');
    Route::get('/karir', [Employee\ProfileController::class, 'career'])->name('employee.profile.career');
});

// ===== ADMIN AUTH =====
Route::prefix('admin')->group(function () {
    Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');
});

// ===== ADMIN PANEL (Auth Required) =====
Route::prefix('admin')->middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Karyawan
    Route::resource('employees', Admin\EmployeeController::class)->names([
        'index' => 'admin.employees.index',
        'create' => 'admin.employees.create',
        'store' => 'admin.employees.store',
        'edit' => 'admin.employees.edit',
        'update' => 'admin.employees.update',
        'destroy' => 'admin.employees.destroy',
        'show' => 'admin.employees.show',
    ]);

    // Career History
    Route::post('/employees/{employee}/career', [Admin\CareerHistoryController::class, 'store'])->name('admin.career.store');

    // Presensi
    Route::get('/presensi', [Admin\AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/presensi/bulanan', [Admin\AttendanceController::class, 'monthly'])->name('admin.attendance.monthly');

    // Approval
    Route::get('/approval/cuti', [Admin\ApprovalController::class, 'leaveIndex'])->name('admin.approval.leave');
    Route::post('/approval/cuti/{leaveRequest}/approve', [Admin\ApprovalController::class, 'leaveApprove'])->name('admin.approval.leave.approve');
    Route::post('/approval/cuti/{leaveRequest}/reject', [Admin\ApprovalController::class, 'leaveReject'])->name('admin.approval.leave.reject');

    Route::get('/approval/izin', [Admin\ApprovalController::class, 'permissionIndex'])->name('admin.approval.permission');
    Route::post('/approval/izin/{permissionRequest}/approve', [Admin\ApprovalController::class, 'permissionApprove'])->name('admin.approval.permission.approve');
    Route::post('/approval/izin/{permissionRequest}/reject', [Admin\ApprovalController::class, 'permissionReject'])->name('admin.approval.permission.reject');

    Route::get('/approval/lembur', [Admin\ApprovalController::class, 'overtimeIndex'])->name('admin.approval.overtime');
    Route::post('/approval/lembur/{overtimeRequest}/approve', [Admin\ApprovalController::class, 'overtimeApprove'])->name('admin.approval.overtime.approve');
    Route::post('/approval/lembur/{overtimeRequest}/reject', [Admin\ApprovalController::class, 'overtimeReject'])->name('admin.approval.overtime.reject');

    // Shift
    Route::get('/shifts', [Admin\ShiftController::class, 'index'])->name('admin.shifts.index');
    Route::post('/shifts', [Admin\ShiftController::class, 'store'])->name('admin.shifts.store');
    Route::put('/shifts/{shift}', [Admin\ShiftController::class, 'update'])->name('admin.shifts.update');
    Route::delete('/shifts/{shift}', [Admin\ShiftController::class, 'destroy'])->name('admin.shifts.destroy');
    Route::get('/shifts/schedule', [Admin\ShiftController::class, 'schedule'])->name('admin.shifts.schedule');
    Route::post('/shifts/schedule', [Admin\ShiftController::class, 'scheduleStore'])->name('admin.shifts.schedule.store');

    // Laporan
    Route::get('/laporan/presensi', [Admin\ReportController::class, 'attendance'])->name('admin.reports.attendance');
    Route::get('/laporan/cuti', [Admin\ReportController::class, 'leave'])->name('admin.reports.leave');
    Route::get('/laporan/lembur', [Admin\ReportController::class, 'overtime'])->name('admin.reports.overtime');

    // Pengaturan
    Route::get('/pengaturan', [Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/pengaturan', [Admin\SettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/pengaturan/libur', [Admin\SettingController::class, 'holidays'])->name('admin.settings.holidays');
    Route::post('/pengaturan/libur', [Admin\SettingController::class, 'holidayStore'])->name('admin.settings.holidays.store');
    Route::delete('/pengaturan/libur/{holiday}', [Admin\SettingController::class, 'holidayDestroy'])->name('admin.settings.holidays.destroy');
    Route::get('/pengaturan/motivasi', [Admin\SettingController::class, 'motivations'])->name('admin.settings.motivations');
    Route::post('/pengaturan/motivasi', [Admin\SettingController::class, 'motivationStore'])->name('admin.settings.motivations.store');
    Route::delete('/pengaturan/motivasi/{motivation}', [Admin\SettingController::class, 'motivationDestroy'])->name('admin.settings.motivations.destroy');
});
