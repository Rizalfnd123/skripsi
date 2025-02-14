<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengabdian extends Model
{
    use HasFactory;

    protected $table = 'pengabdian';
    protected $fillable = [
        'judul',
        'tanggal',
        'id_tingkat',
        'id_roadmap',
        'ketua',
        'keahlian_ketua',
        'dana',
        'dokumen',
        'link_dokumen',
    ];

    // Relasi ke tingkat
    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'id_tingkat');
    }

    // Relasi ke roadmap
    public function roadmap()
    {
        return $this->belongsTo(Roadmap::class, 'id_roadmap');
    }

    // Relasi ke dosen (ketua)
    public function ketuaDosen()
    {
        return $this->belongsTo(Dosen::class, 'ketua');
    }

    // Relasi ke anggota penelitian (tanpa filter)
    public function anggotaPengabdian()
    {
        return $this->hasMany(AnggotaPengabdian::class, 'id_pengabdian', 'id');
    }

    // public function luarans()
    // {
    //     return $this->hasMany(Luaran::class, 'penelitian_id', 'id');
    // }

}
