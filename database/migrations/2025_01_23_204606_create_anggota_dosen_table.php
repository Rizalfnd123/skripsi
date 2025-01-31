<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaDosenTable extends Migration
{
    public function up()
{
    Schema::create('anggota_dosen', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('penelitian_id');
        $table->unsignedBigInteger('dosen_id');
        
        // Definisi foreign key untuk 'penelitian_id'
        $table->foreign('penelitian_id')
            ->references('id_penelitian') // Kolom referensi
            ->on('penelitian') // Nama tabel referensi
            ->onDelete('cascade'); // Hapus relasi jika data induk dihapus
        
        // Definisi foreign key untuk 'dosens_id'
        $table->foreign('dosen_id')
            ->references('id_dosen') // Kolom referensi
            ->on('dosens') // Nama tabel referensi
            ->onDelete('cascade'); // Hapus relasi jika data induk dihapus
        
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('anggota_dosen');
    }
}
