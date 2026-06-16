<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('leave_type_id')->constrained('leave_types')->cascadeOnDelete();
            $table->integer('tahun');
            $table->integer('jatah')->default(12);
            $table->integer('terpakai')->default(0);
            $table->integer('sisa')->default(12);
            $table->timestamps();

            $table->unique(['employee_id', 'leave_type_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
