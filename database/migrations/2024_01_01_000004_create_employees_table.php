<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('pin');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->default('TK');
            $table->string('no_ktp')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('position_id')->nullable()->constrained('positions')->nullOnDelete();
            $table->foreignId('work_shift_id')->nullable()->constrained('work_shifts')->nullOnDelete();
            $table->unsignedBigInteger('atasan_id')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status_karyawan', ['tetap', 'kontrak', 'probation', 'magang'])->default('tetap');
            $table->enum('status', ['aktif', 'nonaktif', 'resign'])->default('aktif');
            $table->string('nama_kontak_darurat')->nullable();
            $table->string('hubungan_kontak_darurat')->nullable();
            $table->string('no_hp_kontak_darurat')->nullable();
            $table->timestamps();

            $table->foreign('atasan_id')->references('id')->on('employees')->nullOnDelete();
        });

        // Add kepala_departemen foreign key after employees table exists
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('kepala_departemen_id')->references('id')->on('employees')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['kepala_departemen_id']);
        });
        Schema::dropIfExists('employees');
    }
};
