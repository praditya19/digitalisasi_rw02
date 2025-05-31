<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ketua_rt', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('nomor_hp');
            $table->string('password');
            $table->integer('rt');
            $table->string('sk_ketua_rt')->nullable();
            $table->string('role')->default('Ketua RT');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ketua_rt');
    }
};
