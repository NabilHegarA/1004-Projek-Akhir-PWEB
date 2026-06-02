<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapaks', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('jenis');

            $table->integer('harga');

            $table->text('deskripsi');

            $table->enum('status', ['available', 'unavailable']);

            $table->string('gambar')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapaks');
    }
};
