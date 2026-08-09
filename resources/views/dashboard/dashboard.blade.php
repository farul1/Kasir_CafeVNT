@extends('dashboard.layout.master')

@section('page-dashboard')

<div class="row justify-content-center">
    <div class="col-lg-4 col-md-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Admin</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
                <li>
                    <div class="icon-card">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                </li>
                <li class="ms-auto"><span class="counter text-success">{{ number_format($total_admin) }}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Manager</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
                <li>
                    <div class="icon-card">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                </li>
                <li class="ms-auto"><span class="counter text-purple">{{ number_format($total_manager) }}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Cashier</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
                <li>
                    <div class="icon-card">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                </li>
                <li class="ms-auto"><span class="counter text-info">{{ number_format($total_cashier) }}</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">List Menu</h3>
            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Gambar Menu</th> <!-- Kolom Gambar Menu -->
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Ketersediaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $key => $menu)
                            <tr>
                                <td>{{ $menus->firstItem() + $key }}</td>
                                <td>{{ $menu->nama_menu }}</td>
                                <td>
                                    <!-- Menampilkan gambar menu jika ada -->
                                    @if($menu->gambar_menu)
                                        <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="Gambar Menu" width="50" height="50">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($menu->harga) }}</td>
                                <td>{{ $menu->deskripsi }}</td>
                                <td>{{ number_format($menu->ketersediaan) }}</td>
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
