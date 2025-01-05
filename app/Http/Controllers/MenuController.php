<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Exports\MenuExport;
use App\Exports\AllTransaksiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;

class MenuController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    private function validateMenu(Request $request)
    {
        return $request->validate([
            'nama_menu' => 'required|string|max:255|min:3',
            'harga' => 'required|numeric|min:1',
            'deskripsi' => 'required|string|max:500|min:15',
            'ketersediaan' => 'required|integer|min:0',
            'gambar_menu' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }

    private function storeImage($image)
    {
        return $image ? $image->store('images', 'public') : null;
    }

    private function logUserAction($actionDescription)
    {
        LogUser::create([
            'username' => auth()->check() ? auth()->user()->username : 'Guest',
            'role' => auth()->check() ? auth()->user()->role : 'Guest',
            'deskripsi' => $actionDescription,
        ]);
    }

    public function index(Request $request)
    {
        $query = Menu::query();

        if ($request->has('pencarian')) {
            $query->where('nama_menu', 'like', '%' . $request->pencarian . '%')
                  ->orWhere('harga', 'like', '%' . $request->pencarian . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->pencarian . '%')
                  ->orWhere('ketersediaan', 'like', '%' . $request->pencarian . '%');
        }

        $menus = $query->latest()->paginate(10);

        return view('dashboard.manager.menu', [
            'title' => 'Dashboard | Menu',
            'menus' => $menus,
        ]);
    }

    public function create()
    {
        return view('dashboard.manager.create', [
            'title' => 'Dashboard | Tambah Menu',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateMenu($request);
        $data['gambar_menu'] = $this->storeImage($request->file('gambar_menu'));

        Menu::create($data);

        $this->logUserAction((auth()->user()->username ?? 'Guest') . ' menambahkan menu: ' . $data['nama_menu']);

        return redirect('/dashboard/menu')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('dashboard.manager.edit', [
            'title' => 'Dashboard | Edit Menu',
            'menu' => $menu,
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $this->validateMenu($request);

        $gambarPath = $this->storeImage($request->file('gambar_menu')) ?? $menu->gambar_menu;

        if ($gambarPath !== $menu->gambar_menu && File::exists(storage_path('app/public/' . $menu->gambar_menu))) {
            File::delete(storage_path('app/public/' . $menu->gambar_menu));
        }

        $data['gambar_menu'] = $gambarPath;

        $menu->update($data);

        $this->logUserAction((auth()->user()->username ?? 'Guest') . ' mengubah menu: ' . $menu->nama_menu);

        return redirect('/dashboard/menu')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->gambar_menu && File::exists(storage_path('app/public/' . $menu->gambar_menu))) {
            File::delete(storage_path('app/public/' . $menu->gambar_menu));
        }

        $menu->delete();

        $this->logUserAction((auth()->user()->username ?? 'Guest') . ' menghapus menu: ' . $menu->nama_menu);

        return redirect('/dashboard/menu')->with('success', 'Menu berhasil dihapus!');
    }

    public function transaksiStore(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menu = Menu::find($request->menu_id);
        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan.');
        }

        $quantity = $request->quantity;

        if ($menu->ketersediaan >= $quantity) {
            $menu->decrement('ketersediaan', $quantity);

            Transaksi::create([
                'menu_id' => $menu->id,
                'quantity' => $quantity,
                'total_harga' => $menu->harga * $quantity,
                'pembayaran_status' => 'pending',
            ]);

            $this->logUserAction((auth()->user()->username ?? 'Guest') . ' melakukan pemesanan: ' . $menu->nama_menu);

            return redirect('/dashboard/menu')->with('success', 'Transaksi berhasil! Ketersediaan telah diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Ketersediaan menu tidak mencukupi.');
        }
    }

    public function transaksi(Request $request)
    {
        $query = Transaksi::query();

        if ($request->has('date1') && $request->has('date2')) {
            $query->whereBetween('created_at', [$request->date1, $request->date2]);
        }

        $transaksis = $query->latest()->paginate(10);

        return view('dashboard.manager.transaksi', [
            'title' => 'Dashboard | Transaksi',
            'transaksis' => $transaksis,
        ]);
    }

    public function exportExcel()
    {
        $this->logUserAction((auth()->user()->username ?? 'Guest') . ' melakukan ekspor (Excel) data menu');
        $fileName = 'menu-export-' . now()->timestamp . '.xlsx';
        return Excel::download(new MenuExport, $fileName);
    }

    public function exportPDF()
    {
        $this->logUserAction((auth()->user()->username ?? 'Guest') . ' melakukan ekspor (PDF) data menu');
        $menus = Menu::all();
        $pdf = PDF::loadView('pdf.menu-pdf', ['menus' => $menus]);
        $fileName = 'menu-export-' . now()->timestamp . '.pdf';
        return $pdf->download($fileName);
    }
}
