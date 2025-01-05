<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use Midtrans\Config;
use Midtrans\CoreApi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\LogUser;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;




class TransaksiController extends Controller
{
    // Menampilkan semua transaksi kasir
    public function index(Request $request)
    {
        $request->validate([
            'date1' => 'nullable|date',
            'date2' => 'nullable|date|after_or_equal:date1',
        ]);

        $query = Transaksi::where('nama_pegawai', auth()->user()->nama);

        if ($request->filled('date1') && $request->filled('date2')) {
            $query->whereBetween('created_at', [$request->date1, $request->date2]);
        }

        $transaksis = $query->latest()->paginate(10)->withQueryString();
        Session::put('transaksis_query', $query->toSql());

        return view('dashboard.cashier.cashier', [
            'title' => 'Dashboard | Cashier',
            'transaksis' => $transaksis,
        ]);
    }

    public function create()
    {
        $menus = Menu::all();
        $title = 'Tambah Transaksi Baru';
        return view('dashboard.cashier.create', compact('menus', 'title'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Data yang diterima:', $request->all());

            // Menentukan status pembayaran
            $statusPembayaran = $request->metode_pembayaran === 'cash' ? 'paid' : ($request->status_pembayaran ?: 'pending');

            // Validasi input
            $validatedData = $request->validate([
                'nama_pelanggan' => 'required|string|max:255',
                'total_harga' => 'required|numeric|min:0',
                'status_pembayaran' => 'pending',
                'metode_pembayaran' => 'required|in:cash,qr',
                'nama_pegawai' => 'required|string|max:255',
                'jumlah' => 'required|array',
                'jumlah.*' => 'nullable|numeric|min:0',
            ]);

            // Mulai transaksi
            DB::beginTransaction();

            // Menyimpan data transaksi
            $transaksi = new Transaksi();
            $transaksi->nama_pelanggan = $request->nama_pelanggan;
            $transaksi->total_harga = $request->total_harga;
            $transaksi->status_pembayaran = $statusPembayaran;
            $transaksi->metode_pembayaran = $request->metode_pembayaran;
            $transaksi->nama_pegawai = $request->nama_pegawai;

            // Membuat ID order jika belum ada
            if (empty($transaksi->order_id)) {
                $transaksi->order_id = 'ORD' . Str::random(8);
            }

            $transaksi->save();
            Log::info('Transaksi berhasil disimpan: ' . $transaksi->id);

            // Variabel untuk menghitung total harga
            $totalHarga = 0;
            $namaMenuList = [];
            $gambarMenuList = [];

            // Proses setiap item dalam jumlah
            foreach ($request->jumlah as $menu_id => $jumlah) {
                if ($jumlah == 0 || $jumlah == null) {
                    continue;
                }

                // Cari menu berdasarkan ID
                $menu = Menu::find($menu_id);

                if (!$menu) {
                    Log::error('Menu tidak ditemukan: ' . $menu_id);
                    DB::rollback();
                    return back()->with('error', 'Menu dengan ID ' . $menu_id . ' tidak ditemukan.');
                }

                // Cek stok menu
                if ($menu->ketersediaan < $jumlah) {
                    Log::error('Stok tidak mencukupi untuk menu: ' . $menu->nama_menu);
                    DB::rollback();
                    return back()->with('error', 'Stok menu ' . $menu->nama_menu . ' tidak mencukupi.');
                }

                // Kurangi stok menu
                $menu->ketersediaan -= $jumlah;
                $menu->save();

                // Simpan detail transaksi
                $transaksiMenu = new DetailTransaksi();
                $transaksiMenu->transaksi_id = $transaksi->id;
                $transaksiMenu->menu_id = $menu_id;
                $transaksiMenu->jumlah = $jumlah;
                $transaksiMenu->harga = $menu->harga;
                $transaksiMenu->nama_menu = $menu->nama_menu;
                $transaksiMenu->gambar_menu = $menu->gambar_menu;
                $transaksiMenu->save();

                // Hitung total harga
                $totalHarga += $menu->harga * $jumlah;

                // Tambahkan nama dan gambar menu ke daftar
                $namaMenuList[] = $menu->nama_menu;
                $gambarMenuList[] = $menu->gambar_menu;
            }

            // Update transaksi dengan total harga
            $transaksi->update(['total_harga' => $totalHarga]);

            // Commit transaksi
            DB::commit();
            Log::info('Transaksi dan detail berhasil disimpan.');

            return redirect()->route('dashboard.cashier.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Terjadi kesalahan: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.')->withInput();
        }
    }
    public function destroy($id)
{
    // Find the transaksi by id
    $transaksi = Transaksi::findOrFail($id);

    // Delete the transaksi
    $transaksi->delete();

    // Redirect with a success message
    return redirect()->route('dashboard.cashier.index')->with('success', 'Transaksi berhasil dihapus');
}

    public function qrPayment(Transaksi $transaksi)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $midtrans_transaction = [
            'transaction_details' => [
                'order_id' => $transaksi->token,
                'gross_amount' => $transaksi->total_harga,
            ],
            'payment_type' => 'qris',
            'callbacks' => [
                'finish' => route('midtrans.payment'),
            ],
        ];

        try {
            $response = CoreApi::charge($midtrans_transaction);

            if (isset($response->actions[0]->url)) {
                $payment_url = $response->actions[0]->url;
                return redirect()->away($payment_url);
            } else {
                return back()->with('error', 'Gagal mendapatkan URL pembayaran.');
            }
        } catch (\Exception $e) {
            \Log::error('Error saat membuat pembayaran QR: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat transaksi dengan Midtrans: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Mengambil transaksi beserta detail transaksi dan menu terkait
        $transaksi = Transaksi::with('detailTransaksis.menu')->find($id);

        // Cek jika transaksi tidak ditemukan
        if (!$transaksi) {
            return redirect()->route('dashboard.cashier.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Menyiapkan data pegawai yang melakukan transaksi
        $nama_pegawai = Auth::user()->name;
        $role = Auth::user()->role;

        // Mengirim data ke view
        return view('dashboard.cashier.show', compact('transaksi', 'nama_pegawai', 'role'));
    }

    public function edit($id)
{
    // Ambil data transaksi berdasarkan ID
    $transaksi = transaksi::findOrFail($id);

    // Ambil semua data menu (jika perlu) untuk dropdown atau tampilan pilihan menu
    $menus = Menu::all();

    // Kirimkan data transaksi dan menu ke view
    return view('dashboard.cashier.edit', compact('transaksi', 'menus'));
}


public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'nama_pelanggan' => 'required|string|max:255',
        'nama_menu' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'total_harga' => 'required|numeric|min:0',
        'nama_pegawai' => 'required|string|max:255',
    ]);

    // Cari transaksi berdasarkan ID
    $transaksi = Transaksi::findOrFail($id);

    // Update data transaksi
    $transaksi->nama_pelanggan = $request->nama_pelanggan;
    $transaksi->nama_pegawai = $request->nama_pegawai;
    $transaksi->total_harga = $request->total_harga;
    $transaksi->save();

    // Jika menggunakan relasi menu, kita bisa update dengan memasukkan data menu sesuai jumlah
    $menu = Menu::where('nama_menu', $request->nama_menu)->first();

    if ($menu) {
        // Asumsikan ada relasi langsung antara transaksi dan menu
        // Update jumlah menu yang dipesan dalam transaksi
        $transaksi->menus()->updateExistingPivot($menu->id, ['jumlah' => $request->jumlah]);
    }

    // Redirect kembali setelah update
    return redirect()->route('dashboard.cashier')->with('success', 'Transaksi berhasil diperbarui');
}

    public function exportExcel()
    {
        $log_user = [
            'username' => auth()->user()->username,
            'role' => auth()->user()->role,
            'deskripsi' => auth()->user()->username . ' melakukan ekspor (Excel) data transaksi pemesanan'
        ];

        LogUser::create($log_user);

        return Excel::download(new TransaksiExport, Str::random(10) . '.xlsx');
    }

    public function exportPDF()
    {
        // Ambil data transaksi dari session
        $data_transaksi = Session::get('transaksis');

        // Jika session kosong, query ulang data transaksi dengan eager loading detailTransaksi
        if (!$data_transaksi || count($data_transaksi) === 0) {
            // Gunakan eager loading untuk relasi 'detailTransaksi'
            $data_transaksi = Transaksi::with('detailTransaksi') // Pastikan nama relasi tanpa "s"
                ->where('nama_pegawai', auth()->user()->nama)
                ->get();

            if (count($data_transaksi) === 0) {
                return response()->json(['message' => 'Data transaksi tidak ditemukan.'], 404);
            }

            // Simpan kembali ke session untuk penggunaan selanjutnya
            Session::put('transaksis', $data_transaksi);
        }

        // Ambil data user
        $data_pegawai = User::where('username', auth()->user()->username)->firstOrFail(); // Ensures an exception is thrown if the user is not found.

        // Log aktivitas pengguna
        LogUser::create([
            'username' => auth()->user()->username,
            'role' => auth()->user()->role,
            'deskripsi' => auth()->user()->username . ' melakukan ekspor (PDF) data transaksi pemesanan'
        ]);

        // Persiapkan data untuk PDF
        $data = [
            'nama_pegawai' => $data_pegawai->nama,
            'role' => $data_pegawai->role,
            'transaksis' => $data_transaksi,  // Mengirimkan transaksi dan detailnya
        ];

        // Membuat PDF dengan DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.cashier-pdf', $data);

        // Mengunduh PDF dengan nama acak
        return $pdf->download(Str::random(10) . '.pdf');
    }


    public function createTransaction(Request $request)
{
    // Log data yang diterima untuk debugging
    Log::info('Data yang diterima:', $request->all());

    // Validasi input berdasarkan metode pembayaran
    $rules = [
        'total_harga' => 'required|numeric|min:1',
        'nama_pelanggan' => 'required|string|max:255',
        'metode_pembayaran' => 'required|in:cash,qr',  // Memastikan metode pembayaran terisi
    ];

    // Lakukan validasi
    $validator = Validator::make($request->all(), $rules);

    // Jika validasi gagal
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Generate Order ID (Unique)
    $orderId = 'INV-' . time() . '-' . Str::random(6);

    // Persiapkan parameter untuk Snap Token jika metode pembayaran QR
    $midtransParams = null;
    $snapToken = null;
    if ($request->metode_pembayaran === 'qr') {
        $midtransParams = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->total_harga,
            ],
            'customer_details' => [
                'first_name' => $request->nama_pelanggan,
            ],
        ];

        // Menghasilkan Snap Token
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);
        } catch (\Exception $e) {
            \Log::error('Error saat membuat Snap Token: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghasilkan Snap Token.'], 500);
        }
    }

    DB::beginTransaction(); // Memulai transaksi untuk menyimpan data transaksi

    try {
        // Simpan transaksi ke database
        $transaksi = new Transaksi();
        $transaksi->order_id = $orderId;
        $transaksi->nama_pelanggan = $request->nama_pelanggan;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->status_pembayaran = 'pending';  // Status sementara, karena belum dibayar
        $transaksi->metode_pembayaran = $request->metode_pembayaran;  // Menyimpan metode pembayaran

        // Jika metode pembayaran adalah cash, simpan nama pegawai
        if ($request->metode_pembayaran === 'cash') {
            $transaksi->nama_pegawai = $request->nama_pegawai;
        }

        $transaksi->save(); // Simpan transaksi ke database

        // Commit transaksi database
        DB::commit();

        // Kembalikan Snap Token ke frontend jika metode QR
        if ($snapToken) {
            return response()->json([
                'token' => $snapToken,
                'order_id' => $orderId, // Bisa mengembalikan order_id untuk referensi
            ]);
        }

        // Jika metode cash, kembalikan hanya order_id
        return response()->json([
            'order_id' => $orderId, // Kembalikan order_id sebagai referensi
        ]);

    } catch (\Exception $e) {
        DB::rollback(); // Jika terjadi error, rollback perubahan
        \Log::error('Error saat menyimpan transaksi: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function paymentSuccess(Request $request)
    {
        $transaksi = Transaksi::where('token', $request->input('order_id'))->first();

        if ($transaksi) {
            $transaksi->update(['status_pembayaran' => 'Paid']);

            foreach ($transaksi->detailTransaksi as $detail) {
                $menu = $detail->menu;
                if ($menu && $menu->ketersediaan >= $detail->jumlah) {
                    $menu->decrement('ketersediaan', $detail->jumlah);
                } else {
                    return response()->json(['error' => 'Stok menu tidak cukup.'], 400);
                }
            }

            return response()->json(['message' => 'Pembayaran berhasil diproses.'], 200);
        }

        return response()->json(['error' => 'Transaksi tidak ditemukan.'], 404);
    }

}
