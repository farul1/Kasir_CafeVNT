@extends('dashboard.layout.master')

@section('page-dashboard')
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <div class="mb-3">
                <h3 class="box-title">{{ $title }}</h3>
                <a href="/dashboard/cashier/create" class="btn btn-success text-white shadow-none">
                    <i class="fa-solid fa-cash-register"></i>&nbsp;&nbsp;Cashier
                </a>
                <a href="/cashier/export/excel" class="btn btn-info text-white shadow-none ms-2">
                    <i class="fa-solid fa-table"></i>&nbsp;&nbsp;Export (Excel)
                </a>
                <a href="/cashier/export/pdf" class="btn btn-danger text-white shadow-none ms-2">
                    <i class="fa-solid fa-file-pdf"></i>&nbsp;&nbsp;Export (PDF)
                </a>
            </div>
            <form method="GET">
                <label class="form-label">Filter Data</label>
                <div class="input-group mb-3">
                    <div class="me-2">
                        <input type="date" class="form-control date" name="date1" value="{{ request('date1') }}">
                    </div>
                    <span class="m-0 py-2">to</span>
                    <div class="ms-2">
                        <input type="date" class="form-control date" name="date2" value="{{ request('date2') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary text-white shadow-none">
                    <i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Cari
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Tabel Transaksi</h3>
            <p class="mb-1">Pegawai <b>({{ Auth::user()->nama }})</b></p>
            <div class="table-responsive">
                @if(session()->has('failed'))
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-xmark"></i>&nbsp;&nbsp;{{ session('failed') }}
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>&nbsp;&nbsp;{{ session('success') }}
                    </div>
                @endif
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th class="border-top-0">No</th>
                            <th class="border-top-0">Nama Pelanggan</th>
                            <th class="border-top-0">Nama Menu</th>
                            <th class="border-top-0">Gambar Menu</th>
                            <th class="border-top-0">Total Harga</th>
                            <th class="border-top-0">Tanggal Transaksi</th>
                            <th class="border-top-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $key => $transaksi)
                            <tr>
                                <td>{{ $transaksis->firstItem() + $key }}</td>
                                <td>{{ $transaksi->nama_pelanggan }}</td>
                                <td>
                                    @foreach($transaksi->detailTransaksi as $detail)
                                        {{ $detail->menu->nama_menu }}@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($transaksi->detailTransaksi as $detail)
                                        @if($detail->menu && $detail->menu->gambar_menu)
                                            <img src="{{ asset('storage/' . $detail->menu->gambar_menu) }}" alt="Gambar Menu" width="50" height="50">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>Rp {{ number_format($transaksi->total_harga) }}</td>
                                <td>{{ $transaksi->created_at }}</td>
                                <td>
                                    <a href="/dashboard/cashier/{{ $transaksi->id }}/edit" class="btn btn-primary shadow-none">Edit</a>
                                    <a href="#" class="btn btn-danger text-white shadow-none" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $transaksi->id }}">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $transaksis->onEachSide(0)->links() }}
</div>

<!-- Modal Delete Confirmation -->
@foreach($transaksis as $transaksi)
    <form action="/dashboard/cashier/{{ $transaksi->id }}" method="POST" id="deleteForm{{ $transaksi->id }}">
        @csrf
        @method('DELETE')
        <div class="modal fade" id="deleteModal{{ $transaksi->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="mb-2">Apakah anda yakin ingin menghapus transaksi berikut?</label>
                        <p><b>Nama Pelanggan</b>: {{ $transaksi->nama_pelanggan }}</p>
                        <p><b>Menu Pesanan</b>:
                            @foreach($transaksi->detailTransaksi as $detail)
                                {{ $detail->menu->nama_menu }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                        <p><b>Total Harga</b>: Rp {{ number_format($transaksi->total_harga) }}</p>
                        <p><b>Nama Pegawai</b>: {{ $transaksi->nama_pegawai }}</p>
                        @foreach($transaksi->detailTransaksi as $detail)
                            @if($detail->menu && $detail->menu->gambar_menu)
                                <img src="{{ asset('storage/' . $detail->menu->gambar_menu) }}" alt="Gambar Menu" width="50" height="50">
                            @endif
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white shadow-none" data-bs-dismiss="modal">Tidak</button>
                        <button type="button" class="btn btn-danger text-white shadow-none" onclick="document.getElementById('deleteForm{{ $transaksi->id }}').submit()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endforeach

@endsection
