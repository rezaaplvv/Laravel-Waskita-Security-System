<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

protected $fillable = [
        'personel_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'foto_masuk',    // Tambahan baru
        'foto_pulang',   // Tambahan baru
        'koordinat_masuk',
        'koordinat_pulang',
        'status'
    ];

    // Relasi ke profil personel
    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }
}
