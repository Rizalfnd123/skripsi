<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaPenelitian extends Model
{
    use HasFactory;

    protected $table = 'anggota_penelitian';
    protected $fillable = ['id_penelitian', 'anggota_id', 'anggota_type'];

    // Relasi ke penelitian
    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'id_penelitian', 'id');
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
