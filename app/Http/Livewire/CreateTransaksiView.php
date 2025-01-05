<?php

namespace App\Http\Livewire;

use App\Models\Menu;
use App\Models\Transaksi; 
use Livewire\Component;

class CreateTransaksiView extends Component
{
    public $menus = [];
    public $nama_pelanggan;
    public $total_harga = 0;
    public $nama_pegawai;

    // Fungsi untuk menghitung total harga
    public function totalHarga()
    {
        $this->total_harga = 0;
        foreach ($this->menus as $menu) {
            $menuData = Menu::find($menu['menu_id']); 
            if ($menuData) {
                $this->total_harga += $menuData->harga * $menu['jumlah'];
            }
        }
    }

    // Validasi inputan setiap kali field diperbarui
    public function updated($field)
    {
        $this->validateOnly($field, [
            'nama_pelanggan' => 'required|max:255|min:3',
            'nama_pegawai' => 'required',
            'menus' => 'required|array',
            'menus.*.menu_id' => 'required|exists:menus,id',
            'menus.*.jumlah' => 'required|integer|min:1', 
        ]);
    }

    // Fungsi mount untuk setup awal komponen
    public function mount($menus)
    {
        $this->menus = $menus;
        $this->nama_pegawai = auth()->user()->nama;
        $this->totalHarga();
    }

    public function submitForm()
    {
        $this->validate([
            'nama_pelanggan' => 'required|max:255|min:3',
            'nama_pegawai' => 'required',
            'menus' => 'required|array',
            'menus.*.menu_id' => 'required|exists:menus,id',
            'menus.*.jumlah' => 'required|integer|min:1',
        ]);

        // Simpan transaksi utama
        $transaksi = Transaksi::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'nama_pegawai' => $this->nama_pegawai,
            'total_harga' => $this->total_harga,
        ]);

        // Simpan detail menu yang dipesan
        foreach ($this->menus as $menu) {
            $transaksi->menus()->attach($menu['menu_id'], ['jumlah' => $menu['jumlah']]);
        }

        // Beri feedback sukses
        session()->flash('message', 'Transaksi berhasil disimpan!');

        // Reset input setelah menyimpan
        $this->reset();
    }

    // Render tampilan
    public function render()
    {
        return view('livewire.create-transaksi-view', [
            'total_harga' => $this->total_harga,
            'menus' => $this->menus,  // Kirim data menus ke tampilan
            'nama_pegawai' => $this->nama_pegawai,
        ]);
    }
}
