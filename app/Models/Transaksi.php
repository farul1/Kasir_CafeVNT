<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'nama_pelanggan',
        'nama_pegawai',
        'total_harga',
        'token',
        'status_pembayaran',
        'metode_pembayaran',
        'order_id',
    ];

    // Relasi dengan DetailTransaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'id');
    }

    // Mutator untuk menghitung dan mengupdate total harga
    public function getTotalHargaAttribute()
    {
        // Periksa jika sudah ada total_harga, gunakan yang disimpan di database
        if (isset($this->attributes['total_harga'])) {
            return $this->attributes['total_harga'];
        }

        // Jika belum ada, hitung dari detail transaksi
        $this->attributes['total_harga'] = $this->detailTransaksi->sum(function ($detail) {
            return $detail->harga * $detail->jumlah;
        });

        return $this->attributes['total_harga'];
    }
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'transaksi_menu')
                    ->withPivot('jumlah'); // Pastikan jumlah ada di tabel pivot
    }




    // Boot model untuk mengatur default value saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            // Membuat token jika kosong, pastikan token unik
            do {
                $token = Str::uuid()->toString();
            } while (Transaksi::where('token', $token)->exists());

            $transaksi->token = $token;

            // Set status pembayaran default ke 'pending' jika kosong
            if (empty($transaksi->status_pembayaran)) {
                $transaksi->status_pembayaran = 'pending';
            }

            // Set metode pembayaran jika kosong
            if (empty($transaksi->metode_pembayaran)) {
                $transaksi->metode_pembayaran = 'cash';  // Misalnya default cash
            }
        });
    }

    // Update status pembayaran
    public function updateStatusPembayaran($status)
    {
        // Daftar status yang diizinkan dan status pembayarannya
        $statusPembayaran = [
            'capture' => 'paid',
            'settlement' => 'paid',
            'pending' => 'pending',
            'cancel' => 'cancelled',
            'expire' => 'expired',
            'refund' => 'refunded'
        ];

        // Tentukan status pembayaran yang baru atau tetap unknown jika tidak ditemukan
        $newStatus = $statusPembayaran[$status] ?? null;

        // Update status jika memang ada perubahan
        if ($newStatus && $this->status_pembayaran !== $newStatus) {
            $this->status_pembayaran = $newStatus;
            $this->save();
        }

        return $this->status_pembayaran;
    }

    // Hitung dan update total harga transaksi, tapi hindari looping save() yang tidak perlu
    public function updateTotalHarga()
    {
        // Hitung total harga dari detail transaksi
        $totalHarga = $this->detailTransaksi->sum(function ($detail) {
            return $detail->harga * $detail->jumlah;
        });

        // Hanya update total harga jika memang ada perubahan
        if ($this->total_harga !== $totalHarga) {
            $this->attributes['total_harga'] = $totalHarga;
            $this->saveQuietly();  // Hindari memicu event saving() lagi
        }
    }

}

