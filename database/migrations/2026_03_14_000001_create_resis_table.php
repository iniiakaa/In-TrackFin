<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_resi')->unique();
            $table->string('nama_pengirim');
            $table->string('nama_penerima');
            $table->string('alamat_tujuan');
            $table->decimal('berat_barang', 10, 2);
            $table->decimal('tarif', 15, 2);
            $table->enum('status', ['tiba_di_cabang', 'sedang_diproses', 'dibawa_kurir', 'selesai'])->default('tiba_di_cabang');
            $table->text('catatan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resis');
    }
};
