<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita'); // Kolom ID berita
            $table->date('tanggal'); // Kolom tanggal
            $table->string('foto'); // Kolom foto
            $table->string('judul'); // Kolom judul
            $table->text('keterangan'); // Kolom keterangan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
