<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding-top: 20px;
        }

        h3 {
            text-align: center;
            color: #5a3300;
            font-size: 28px;
            margin-top: 0;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .info {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        .table, .table th, .table td {
            border: 1px solid #ddd;
        }

        .table th, .table td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
            vertical-align: middle;
        }

        .table th {
            background-color: #5a3300;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table td:last-child {
            text-align: left;
        }

        .img-menu {
            max-width: 50px;
            height: auto;
            margin-right: 10px;  /* Menambahkan jarak antara gambar dengan teks lainnya */
        }

        .no-image {
            color: #999;
            font-style: italic;
        }

        .currency {
            text-align: right;
        }

        /* Mobile responsive design */
        @media (max-width: 768px) {
            .table, .table th, .table td {
                font-size: 12px;
            }

            .img-menu {
                max-width: 80px; /* Maksimal lebar gambar pada perangkat kecil */
                height: auto;
            }

            .table th, .table td {
                padding: 8px;
            }
        }
    </style>
    <title>Data Transaksi</title>
</head>
<body>
    <div class="container">
        <h3>Data Transaksi</h3>
        <p><strong>Nama Pegawai:</strong> {{ $nama_pegawai }}</p>
        <p><strong>Role:</strong> {{ $role }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Menu</th>
                    <th>Total Harga</th>
                    <th>Nama Pegawai</th>
                    <th>Tanggal Transaksi</th>
                    <th>Gambar Menu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaksi->nama_pelanggan }}</td>
                        <td>
                            @foreach($transaksi->detailTransaksi as $detail)
                                <p>{{ $detail->nama_menu ?? 'Nama Menu Tidak Tersedia' }}</p>
                            @endforeach
                        </td>
                        <td class="currency">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $nama_pegawai }}</td>
                        <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                        <td>
                            @foreach($transaksi->detailTransaksi as $detail)
                                @if($detail->gambar_menu)
                                    <img src="{{ public_path('storage/' . $detail->gambar_menu) }}" alt="Gambar Menu" class="img-menu">
                                @else
                                    <span class="no-image">Gambar Tidak Tersedia</span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
