<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaksi;

class Menu extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak menggunakan konvensi default
    protected $table = 'menus';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = ['nama_menu', 'harga', 'deskripsi', 'ketersediaan', 'gambar_menu'];

    // Menonaktifkan timestamps jika tidak menggunakan kolom created_at dan updated_at
    public $timestamps = true; // Pastikan tabel memiliki kolom created_at dan updated_at, jika tidak set false

    /**
     * Relasi dengan DetailTransaksi (Menu yang dipesan dalam transaksi).
     * Setiap menu bisa dimasukkan ke dalam banyak transaksi (detail transaksi).
     */
    public function transaksiDetails()
    {
        // Relasi satu-ke-banyak ke DetailTransaksi
        return $this->hasMany(DetailTransaksi::class, 'menu_id', 'id');
    }
    public function transaksi()
{
    return $this->belongsToMany(Transaksi::class, 'transaksi_menu')
                ->withPivot('jumlah'); // Pastikan jumlah ada di tabel pivot
}

    /**
     * Menambahkan accessor untuk mendapatkan harga dalam format yang lebih mudah dibaca.
     * Misalnya, format harga dengan dua angka desimal dan simbol mata uang.
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
