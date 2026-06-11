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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('personel_id')->constrained('personels')->onDelete('cascade');
        $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Lokasi kejadian
        $table->enum('tipe_laporan', ['patroli', 'insiden']); // Sesuai rumusan masalah[cite: 1]
        $table->text('deskripsi');
        $table->string('foto_kejadian')->nullable(); // Untuk bukti dokumentasi[cite: 1]
        $table->string('koordinat_gps')->nullable(); // Monitoring real-time[cite: 1]
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
