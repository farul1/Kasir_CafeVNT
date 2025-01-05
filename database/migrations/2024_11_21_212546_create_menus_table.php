<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Menonaktifkan sementara pemeriksaan kunci asing
        Schema::disableForeignKeyConstraints();

        // Hapus tabel 'menus' jika sudah ada (untuk pengaturan ulang)
        Schema::dropIfExists('menus');

        // Buat tabel 'menus' baru
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu')->unique();  // Nama menu harus unik
            $table->decimal('harga', 10, 2)->default(0);  // Harga dengan skala 10, 2
            $table->longText('deskripsi');  // Deskripsi menu
            $table->unsignedInteger('ketersediaan')->default(0);  // Ketersediaan menu
            $table->string('gambar_menu')->nullable();  // Gambar menu (opsional)
            $table->timestamps();
            $table->index('nama_menu');  // Indeks untuk nama_menu
        });

        // Jika tabel 'order_items' ada, update kolom foreign key 'menu_id'
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                // Periksa apakah kolom 'menu_id' ada, kemudian buat ulang foreign key
                if (Schema::hasColumn('order_items', 'menu_id')) {
                    $table->dropForeign(['menu_id']);  // Hapus foreign key lama
                    // Buat foreign key baru yang mengacu ke 'menus' dan hapus data terkait jika menu dihapus
                    $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
                }
            });
        }

        // Mengaktifkan kembali pemeriksaan kunci asing
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        // Menonaktifkan sementara pemeriksaan kunci asing
        Schema::disableForeignKeyConstraints();

        // Jika ada foreign key di 'order_items' pada kolom 'menu_id', hapus
        if (Schema::hasTable('order_items') && Schema::hasColumn('order_items', 'menu_id')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropForeign(['menu_id']);  // Hapus foreign key dari 'menu_id'
            });
        }

        // Hapus tabel 'menus'
        Schema::dropIfExists('menus');

        // Mengaktifkan kembali pemeriksaan kunci asing
        Schema::enableForeignKeyConstraints();
    }
};
