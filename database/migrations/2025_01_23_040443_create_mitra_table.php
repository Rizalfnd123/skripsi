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
        Schema::create('mitra', function (Blueprint $table) {
            $table->id('id_mitra');
            $table->string('nama');
            $table->string('no_hp');
            $table->string('username');
            $table->string('password');
            $table->enum('status', ['tervalidasi', 'tidak']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mitra');
    }
};
