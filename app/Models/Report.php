<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi
    protected $fillable = [
        'personel_id',
        'client_id',
        'tipe_laporan',
        'deskripsi',
        'foto_kejadian',
        'koordinat_gps'
    ];

    // Relasi ke Personel (Siapa yang melapor)
    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }

    // Relasi ke Klien/Lokasi (Dimana laporan itu dibuat)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}