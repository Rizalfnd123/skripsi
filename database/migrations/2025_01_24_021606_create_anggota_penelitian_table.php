<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaPenelitianTable extends Migration
{
    public function up()
    {
        Schema::create('anggota_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penelitian')->constrained('penelitian')->onDelete('cascade');
            $table->unsignedBigInteger('anggota_id');
            $table->string('anggota_type'); // Dosen/Mahasiswa
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_penelitian');
    }
}
