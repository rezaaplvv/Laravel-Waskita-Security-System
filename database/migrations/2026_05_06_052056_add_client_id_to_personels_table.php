<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personels', function (Blueprint $table) {
            // Menambahkan kolom client_id tepat setelah kolom user_id
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null')->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('personels', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};