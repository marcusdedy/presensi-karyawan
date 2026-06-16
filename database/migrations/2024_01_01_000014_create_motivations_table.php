<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motivations', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['masuk', 'pulang']);
            $table->string('kategori')->default('umum');
            $table->text('pesan');
            $table->string('gif_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motivations');
    }
};
