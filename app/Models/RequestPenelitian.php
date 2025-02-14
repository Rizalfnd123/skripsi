<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPenelitian extends Model
{
    use HasFactory;

    protected $table = 'requests'; // Sesuai dengan nama tabel di database
    protected $fillable = ['id_penelitian', 'id_mitra', 'keterangan'];
}
