<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenelitianTable extends Migration
{
    public function up()
    {
        Schema::create('penelitian', function (Blueprint $table) {
            $table->id('id_penelitian');
            $table->string('judul');
            $table->date('tanggal');
            $table->foreignId('id_tingkat')->constrained('tingkat')->onDelete('cascade');
            $table->foreignId('id_roadmap')->constrained('roadmap')->onDelete('cascade');
            $table->foreignId('ketua')->constrained('dosens')->onDelete('cascade');
            $table->string('keahlian_ketua');
            $table->string('dana');
            $table->string('dokumen')->nullable();
            $table->string('link_dokumen')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penelitian');
    }
}
