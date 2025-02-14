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
        Schema::create('anggota_pengabdian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengabdian')->constrained('pengabdian')->onDelete('cascade');
            $table->unsignedBigInteger('anggota_id');
            $table->string('anggota_type'); // Dosen/Mahasiswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_pengabdian');
    }
};
