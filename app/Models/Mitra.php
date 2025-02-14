<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mitra extends Authenticatable
{
    use HasFactory;

    protected $guard = 'mitra'; // Menentukan guard yang digunakan

    protected $table = 'mitra'; // Nama tabel
    protected $primaryKey = 'id'; // Kunci utama tabel

    protected $fillable = [
        'nama', 'no_hp', 'username', 'password', 'status',
    ];

    protected $hidden = [
        'password',
    ];

    // Agar password bisa di-hash otomatis
    protected $casts = [
        'password' => 'hashed',
    ];
}
