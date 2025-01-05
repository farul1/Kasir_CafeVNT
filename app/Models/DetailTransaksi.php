<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'jumlah',
        'harga',
    ];

    public $timestamps = false;

    // Relasi ke model Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Relasi ke model Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Mutator untuk menghitung total harga
    public function getTotalHargaAttribute()
    {
        return isset($this->harga, $this->jumlah) ? $this->harga * $this->jumlah : 0;
    }

    public function detailTransaksi()
{
    return $this->hasMany(DetailTransaksi::class); // Assuming it's a one-to-many relationship
}


    // Boot model untuk validasi otomatis
    protected static function boot()
    {
        parent::boot();

        // Validasi sebelum membuat data baru
        static::creating(function ($detailTransaksi) {
            $detailTransaksi->validate();
        });

        // Validasi sebelum memperbarui data
        static::updating(function ($detailTransaksi) {
            $detailTransaksi->validate();
        });
    }

    // Fungsi untuk validasi data
    private function validate()
    {
        // Validasi field dengan menggunakan Validator facade
        $validator = Validator::make(
            $this->attributes,  // Validasi berdasarkan seluruh atribut model
            [
                'jumlah' => 'required|integer|gt:0', // Pastikan jumlah adalah integer yang valid
                'harga' => 'required|numeric|gt:0',  // Pastikan harga adalah angka yang valid
            ],
            [
                'jumlah.required' => 'Jumlah harus diisi.',
                'jumlah.gt' => 'Jumlah harus lebih dari 0.',
                'harga.required' => 'Harga harus diisi.',
                'harga.gt' => 'Harga harus lebih dari 0.',
            ]
        );

        // Jika validasi gagal, lempar exception dengan pesan kesalahan
        if ($validator->fails()) {
            throw new ValidationException($validator, response()->json($validator->errors(), 422));
        }
    }
}
