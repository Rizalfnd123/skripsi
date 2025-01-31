<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra'; // Nama tabel
    protected $primaryKey = 'id_mitra'; // Kunci utama tabel

    protected $fillable = [
        'nama', 'no_hp', 'username', 'password', 'status',
    ];
}
