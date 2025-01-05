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
            margin-top: 10px;
        }

        .table, .table th, .table td {
            border: 1px solid #ddd;
        }

        .table th, .table td {
            padding: 12px;
            text-align: center;
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

        .table td {
            font-size: 14px;
        }

        .table td:last-child {
            text-align: left;
        }

        .img-menu {
            width: 50px;  /* Ukuran gambar menu */
            height: auto;
            max-height: 50px;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .table, .table th, .table td {
                font-size: 12px;
                padding: 8px;
            }

            .img-menu {
                width: 40px;
            }
        }
    </style>
    <title>Data Menu</title>
</head>
<body>
    <div class="container">
        <h3>VNTCoffee</h3>
        <div class="info">
            <p><b>Nama Pegawai</b>: {{ $nama_pegawai }}</p>
            <p><b>Role</b>: {{ $role }}</p>
        </div>
        <p class="title">Data Menu</p>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Ketersediaan</th>
                    <th>Gambar Menu</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $menu->nama_menu }}</td>
                        <td>Rp {{ number_format($menu->harga) }}</td>
                        <td>{{ $menu->deskripsi }}</td>
                        <td>{{ number_format($menu->ketersediaan) }}</td>
                        <td>
                            @if($menu->gambar_menu)
                                <img src="{{ public_path('storage/'.$menu->gambar_menu) }}" class="img-menu" alt="Gambar Menu">
                            @else
                                <span>Gambar Tidak Tersedia</span>
                            @endif
                        </td>
                        <td>{{ $menu->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
