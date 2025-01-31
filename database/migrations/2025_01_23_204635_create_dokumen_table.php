<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenTable extends Migration
{
    public function up()
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penelitian_id');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('penelitian_id')
            ->references('id_penelitian') // Kolom referensi
            ->on('penelitian') // Nama tabel referensi
            ->onDelete('cascade'); // Hapus relasi jika data induk dihapus
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen');
    }
}
