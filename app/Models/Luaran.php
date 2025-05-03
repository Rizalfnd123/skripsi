<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Luaran extends Model
{
    protected $fillable = [
        'tipe',
        'dokumen',
        'judul',
        'tahun',
        'link',
        'sinta',
        'nomor_pengajuan',
        'pencipta',
        'pemegang_hak_cipta',
        'nama_karya',
        'jenis',
        'tanggal_diterima',
        'penerbit',
        'penulis',
        'nama_video',
        'luarable_id',
        'luarable_type',
        'penyelenggara',
        'tempat_konferensi',
        'tgl_konferensi',
        'nama_konferensi',
        'isbn',
    ];

    public function luarable()
    {
        return $this->morphTo();
    }
}

