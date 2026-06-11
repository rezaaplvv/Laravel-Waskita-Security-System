<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        // Relasi langsung ke tabel personels
        $table->foreignId('personel_id')->constrained('personels')->onDelete('cascade');
        $table->date('tanggal');
        $table->time('jam_masuk')->nullable();
        $table->time('jam_pulang')->nullable();
        $table->string('koordinat_masuk')->nullable(); // Menyiapkan fitur GPS ke depannya[cite: 1]
        $table->string('koordinat_pulang')->nullable();
        $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa'])->default('Hadir');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
