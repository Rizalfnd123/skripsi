<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuaransTable extends Migration
{
    public function up()
    {
        Schema::create('luarans', function (Blueprint $table) {
            $table->id();

            // Relasi polymorphic ke Penelitian atau Pengabdian
            $table->unsignedBigInteger('luarable_id');
            $table->string('luarable_type'); // App\Models\Penelitian atau App\Models\Pengabdian

            // Tipe luaran: jurnal, hki, isbn, prosiding, video
            $table->string('tipe');

            // Kolom Umum
            $table->string('dokumen')->nullable();
            $table->string('judul')->nullable();
            $table->string('tahun')->nullable();
            $table->string('link')->nullable();

            // Kolom Jurnal
            $table->string('sinta')->nullable();

            // Kolom HKI
            $table->string('nomor_pengajuan')->nullable();
            $table->string('pencipta')->nullable();
            $table->string('pemegang_hak_cipta')->nullable();
            $table->string('nama_karya')->nullable();
            $table->string('jenis')->nullable();
            $table->date('tanggal_diterima')->nullable();

            // Kolom ISBN
            $table->string('penerbit')->nullable();
            $table->string('penulis')->nullable();

            // Kolom Video
            $table->string('nama_video')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('luarans');
    }
}
