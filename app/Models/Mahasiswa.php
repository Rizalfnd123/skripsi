<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';

    // Allow mass assignment
    protected $fillable = ['nama', 'nim', 'jenis_kelamin', 'angkatan', 'no_hp'];
    public function penelitian()
    {
        return $this->belongsToMany(Penelitian::class, 'anggota_mahasiswa', 'id_mahasiswa', 'penelitian_id');
    }
}
