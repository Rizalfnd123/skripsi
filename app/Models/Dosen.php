<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'email', 'nip','nidn', 'jenis_kelamin', 'foto'];

    public function penelitian()
    {
        return $this->belongsToMany(Penelitian::class, 'anggota_dosen', 'id_dosen', 'penelitian_id');
    }
}
