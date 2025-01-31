<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penelitian', function (Blueprint $table) {
            $table->id('id_penelitian');
            $table->string('judul');
            $table->date('tanggal');
            $table->unsignedBigInteger('id_tingkat'); // Relasi ke tabel tingkat
            $table->unsignedBigInteger('id_roadmap'); // Relasi ke tabel roadmap
            $table->unsignedBigInteger('ketua'); // Relasi ke tabel dosen
            $table->json('anggota_dosen')->nullable(); // Array JSON untuk anggota dosen
            $table->json('anggota_mhs')->nullable(); // Array JSON untuk anggota mahasiswa
            $table->unsignedBigInteger('mitra'); // Relasi ke tabel mitra
            $table->string('keahlian_ketua')->nullable();
            $table->string('dana')->nullable();
            $table->string('dokumen')->nullable();
            $table->string('link_dokumen')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('id_tingkat')->references('id_tingkat')->on('tingkat')->onDelete('cascade');
            $table->foreign('id_roadmap')->references('id')->on('roadmap')->onDelete('cascade');
            $table->foreign('ketua')->references('id_dosen')->on('dosens')->onDelete('cascade');
            $table->foreign('mitra')->references('id_mitra')->on('mitra')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penelitian');
    }
};
