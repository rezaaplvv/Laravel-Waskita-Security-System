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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // user_id ini disiapkan untuk akun login portal Klien ke depannya
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); 
            $table->string('nama_perusahaan');
            $table->string('lokasi_penjagaan'); // Contoh: Gudang A, Perumahan B
            $table->text('alamat_lengkap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
