<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'lokasi_penjagaan',
        'alamat_lengkap'
    ];

    // Satu lokasi penjagaan bisa diisi oleh banyak personel
    public function personels()
    {
        return $this->hasMany(Personel::class);
    }

    // Relasi ke tabel users (untuk akses login Portal Klien)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}