<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_keluarga')->nullable()->unique();
            $table->string('nik')->unique()->nullable();
            $table->string('nama_lengkap');
            $table->string('email')->unique()->nullable();
            $table->string('nomor_hp')->nullable();
            $table->integer('rt');
            $table->string('jenis_kelamin')->nullable();
            $table->string('status_rumah')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('jenis_warga', ['Kepala Keluarga', 'Anggota Keluarga'])->default('Anggota Keluarga');
            $table->string('status_keluarga')->nullable();
            $table->unsignedBigInteger('kepala_keluarga_id')->nullable();
            $table->foreign('kepala_keluarga_id')->references('id')->on('warga')->onDelete('cascade');
            $table->string('domisili')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
