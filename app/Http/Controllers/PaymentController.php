<?php

namespace App\Http\Controllers;

use Midtrans\Notification;
use Midtrans\Config;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set up Midtrans configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function midtransCallback(Request $request)
    {
        // Ambil data yang dikirim oleh Midtrans
        $orderId = $request->get('order_id');
        $signatureKey = $request->get('signature_key');
        $grossAmount = $request->get('gross_amount');

        // Membuat string untuk menghasilkan signature
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashString = $orderId . $grossAmount . $serverKey;

        // Generate signature manual
        $generatedSignature = hash('sha512', $hashString);

        // Verifikasi apakah signature yang diterima sama dengan signature yang dihitung
        if ($signatureKey !== $generatedSignature) {
            return response()->json(['status' => 'error', 'message' => 'Signature tidak valid'], 403);
        }

        // Cari transaksi berdasarkan order_id
        $transaksi = Transaksi::where('id', $orderId)->first();

        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Ambil status transaksi dari request
        $status = $request->get('status');

        // Tentukan status pembayaran berdasarkan status dari Midtrans
        if ($status == 'capture' && $request->get('fraud_status') == 'accept') {
            $transaksi->status_pembayaran = 'paid';
        } elseif ($status == 'settlement') {
            $transaksi->status_pembayaran = 'paid';
        } else {
            $transaksi->status_pembayaran = 'pending';
        }

        // Simpan perubahan status transaksi
        $transaksi->save();

        // Tindakan lanjutan (misalnya kirim email, notifikasi admin)
        // $this->sendConfirmationEmail($transaksi);

        return response()->json(['status' => 'success']);
    }
}
