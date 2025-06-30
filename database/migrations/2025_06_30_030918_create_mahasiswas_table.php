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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama');
            $table->string('jurusan');
            $table->integer('angkatan');
            $table->string('email')->unique();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Cuti', 'Lulus'])->default('Aktif');
            $table->decimal('ipk', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
