<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaPengabdian extends Model
{
    use HasFactory;

    protected $table = 'anggota_pengabdian';
    protected $fillable = ['id_pengabdian', 'anggota_id', 'anggota_type'];

    // Relasi ke penelitian
    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class, 'id_pengabdian', 'id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'anggota_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'anggota_id', 'id_mahasiswa');
    }

    // Polymorphic: Bisa ke dosen atau mahasiswa
    public function anggota()
    {
        return $this->morphTo();
    }
    
}
