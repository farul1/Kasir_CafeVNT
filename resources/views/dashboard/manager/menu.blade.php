@extends('dashboard.layout.master')

@section('page-dashboard')

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Manager Dashboard</h3>
            <div class="mb-3">
                <a href="/dashboard/menu/create" class="btn btn-success text-white shadow-none">
                    <i class="fa-brands fa-readme"></i>&nbsp;&nbsp;Tambah Menu
                </a>
                <a href="/menu/export/excel" class="btn btn-info text-white shadow-none ms-2">
                    <i class="fa-solid fa-table"></i>&nbsp;&nbsp;Export (Excel)
                </a>
                <a href="/menu/export/pdf" class="btn btn-danger text-white shadow-none ms-2">
                    <i class="fa-solid fa-file-pdf"></i>&nbsp;&nbsp;Export (PDF)
                </a>
            </div>

            <form method="GET" action="/dashboard/menu" class="mb-3">
                <label class="form-label">Filter Data</label>
                <div class="input-group">
                    <input type="text" class="form-control pencarian" name="pencarian" placeholder="Pencarian" autocomplete="off" value="{{ request('pencarian') }}">
                    <button type="submit" class="btn btn-secondary text-white shadow-none" id="button-addon2">
                        <i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Tabel Menu</h3>
            <div class="table-responsive">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>&nbsp;&nbsp;{{ session('success') }}
                    </div>
                @endif
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th class="border-top-0">No</th>
                            <th class="border-top-0">Nama Menu</th>
                            <th class="border-top-0">Gambar Menu</th>
                            <th class="border-top-0">Harga</th>
                            <th class="border-top-0">Deskripsi</th>
                            <th class="border-top-0">Ketersediaan</th>
                            <th class="border-top-0">Tanggal Ditambahkan</th>
                            <th class="border-top-0 text-white">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $key => $menu)
                            <tr>
                                <td>{{ $menus->firstItem() + $key }}</td>
                                <td>{{ $menu->nama_menu }}</td>
                                <td>
                                    @if($menu->gambar_menu)
                                        <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="Gambar Menu" width="50" height="50">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td>{{ $menu->deskripsi }}</td>
                                <td>{{ number_format($menu->ketersediaan, 0, ',', '.') }}</td>
                                <td>{{ $menu->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="/dashboard/menu/{{ $menu->id }}/edit" class="btn btn-primary shadow-none">Edit</a>
                                    <a href="#" class="btn btn-danger text-white shadow-none" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $menu->id }}">Hapus</a>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label class="mb-2">Apakah anda yakin ingin menghapus menu berikut ?</label>
                                                    <p><b>Nama Menu:</b> {{ $menu->nama_menu }}</p>
                                                    <p><b>Harga:</b> Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                                    @if($menu->gambar_menu)
                                                        <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="Gambar Menu" width="50" height="50">
                                                    @else
                                                        <span>No Image</span>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Tidak</button>
                                                    <form action="/dashboard/menu/{{ $menu->id }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger text-white">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $menus->onEachSide(0)->links() }}
</div>

@endsection
