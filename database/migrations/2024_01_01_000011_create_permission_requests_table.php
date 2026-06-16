<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('tipe', ['terlambat', 'pulang_cepat']);
            $table->date('tanggal');
            $table->time('jam_rencana');
            $table->time('jam_normal');
            $table->integer('durasi_menit');
            $table->text('alasan');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('catatan_approval')->nullable();
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_requests');
    }
};
