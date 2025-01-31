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
        Schema::create('roadmap', function (Blueprint $table) {
            $table->id(); // Kolom id
            $table->string('jenis_roadmap'); // Kolom jenis_roadmap
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('roadmap');
    }
};
