<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    use HasFactory;

    protected $table = 'tingkat';
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_tingkat'];
}
