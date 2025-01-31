<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luaran extends Model
{
    use HasFactory;

    protected $fillable = ['penelitian_id', 'tipe', 'dokumen'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }
}
