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
    Schema::create('luarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('penelitian_id')->constrained()->onDelete('cascade');
        $table->enum('tipe', ['jurnal', 'HKI', 'produk', 'sertifikat']);
        $table->string('dokumen')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luarans');
    }
};
