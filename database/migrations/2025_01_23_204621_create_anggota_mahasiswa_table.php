<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaMahasiswaTable extends Migration
{
    public function up()
{
    Schema::create('anggota_mahasiswa', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('penelitian_id');
        $table->unsignedBigInteger('mahasiswa_id');
        
        // Definisi foreign key untuk 'penelitian_id'
        $table->foreign('penelitian_id')
            ->references('id_penelitian') // Kolom referensi
            ->on('penelitian') // Nama tabel referensi
            ->onDelete('cascade'); // Hapus relasi jika data induk dihapus
        
        // Definisi foreign key untuk 'dosens_id'
        $table->foreign('mahasiswa_id')
            ->references('id_mahasiswa') // Kolom referensi
            ->on('mahasiswa') // Nama tabel referensi
            ->onDelete('cascade'); // Hapus relasi jika data induk dihapus
        
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('anggota_mahasiswa');
    }
}
