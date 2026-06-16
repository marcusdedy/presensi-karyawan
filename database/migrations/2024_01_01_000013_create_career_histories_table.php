<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('tipe', ['promosi', 'demosi', 'mutasi', 'rotasi', 'perubahan_status']);
            $table->date('tanggal_efektif');
            $table->string('jabatan_lama')->nullable();
            $table->string('jabatan_baru')->nullable();
            $table->string('departemen_lama')->nullable();
            $table->string('departemen_baru')->nullable();
            $table->string('lokasi_lama')->nullable();
            $table->string('lokasi_baru')->nullable();
            $table->string('status_lama')->nullable();
            $table->string('status_baru')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('file_sk')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_histories');
    }
};
