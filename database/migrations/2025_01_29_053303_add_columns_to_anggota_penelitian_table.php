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
        Schema::table('anggota_penelitian', function (Blueprint $table) {
            $table->unsignedBigInteger('anggotaable_id');
            $table->string('anggotaable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota_penelitian', function (Blueprint $table) {
            $table->dropColumn('anggotaable_id');  // Menghapus kolom description
            $table->dropColumn('anggotaable_type');  // Menghapus kolom status
        });
    }
};
