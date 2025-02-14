<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengabdian', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->foreignId('id_tingkat')->constrained('tingkat')->onDelete('cascade');
            $table->foreignId('id_roadmap')->constrained('roadmap')->onDelete('cascade');
            $table->foreignId('ketua')->constrained('dosens')->onDelete('cascade');
            $table->string('keahlian_ketua')->nullable();
            $table->string('dana')->nullable();
            $table->string('dokumen')->nullable();
            $table->string('link_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengabdian');
    }
};
