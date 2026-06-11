<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    use HasFactory;

    // Tambahkan 'client_id' ke dalam array ini
    protected $fillable = [
        'user_id',
        'client_id', // Ini wajib ditambahkan
        'nip',
        'nama_lengkap',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'foto_profil'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi ini agar personel tahu dia menjaga di mana
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}