<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Membuat tabel 'menus'
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu')->unique();
            $table->decimal('harga', 10, 2)->default(0);
            $table->longText('deskripsi');
            $table->unsignedInteger('ketersediaan')->default(0);  // Ketersediaan menu
            $table->string('gambar_menu')->nullable();  // Optional gambar menu
            $table->timestamps();
            $table->index('nama_menu');
        });

        // Membuat tabel 'transaksi'
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('nama_pegawai', 255)->nullable();  // Nama pegawai bisa null
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->enum('status_pembayaran', ['pending', 'paid', 'cancelled', 'expired', 'refunded', 'unknown'])->default('pending');
            $table->enum('metode_pembayaran', ['cash', 'qr'])->nullable();
            $table->string('token', 255)->nullable()->unique();
            $table->timestamps();
            $table->index('nama_pelanggan');
            $table->index('nama_pegawai');
        });

        // Membuat tabel 'detail_transaksi'
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->unsignedInteger('jumlah');
            $table->decimal('harga', 10, 2)->default(0);  // Harga menu saat transaksi terjadi
            $table->timestamps();
        });
    }

    public function down()
    {
        // Hapus tabel-tabel
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('menus');
    }
};
