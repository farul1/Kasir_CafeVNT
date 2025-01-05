@section('title', 'Tambah Transaksi Baru')

<div class="container">
    <h2>Tambah Transaksi Baru</h2>

    <!-- Alert success / error -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            <i class="fa fa-times-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Form Transaksi -->
    <form action="{{ route('dashboard.cashier.store') }}" method="POST" id="transaction-form">
        @csrf

        <!-- Nama Pelanggan -->
        <div class="form-group mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan') }}" placeholder="Masukkan Nama Pelanggan" required>
            @error('nama_pelanggan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pilih Menu -->
        <div class="form-group mb-3">
            <label for="menu" class="form-label">Pilih Menu</label>
            <div class="row">
                @foreach($menus as $menu)
                    <div class="col-md-3 mb-3">
                        <div class="menu-item text-center">
                            <label for="menu-{{ $menu->id }}">
                                <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" class="img-fluid" style="width: 100px; height: 100px;">
                                <p>{{ $menu->nama_menu }}<br>Rp. {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                <p>Stok: <span id="stok-{{ $menu->id }}">{{ $menu->ketersediaan }}</span></p>
                            </label>
                            <input type="number" name="jumlah[{{ $menu->id }}]" class="form-control mt-2 jumlah-menu" data-id="{{ $menu->id }}" data-price="{{ $menu->harga }}" placeholder="Jumlah" min="0" value="{{ old('jumlah.' . $menu->id, 0) }}" onchange="updateTotal()">
                            <div class="text-danger error-message"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="form-group mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" id="metode_pembayaran" onchange="toggleBayarButton()" required>
                <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="qr" {{ old('metode_pembayaran') == 'qr' ? 'selected' : '' }}>QR Payment</option>
            </select>
        </div>

        <!-- Total Harga -->
        <div class="form-group mb-3">
            <label for="total_harga" class="form-label">Total Harga</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control" name="total_harga" id="total_harga" value="{{ old('total_harga', 0) }}" readonly>
            </div>
        </div>

        <!-- Nama Pegawai -->
        <div class="form-group mb-3">
            <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
            <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" value="{{ auth()->user() ? auth()->user()->nama : 'Nama Pegawai Tidak Ditemukan' }}" readonly>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-primary" id="submitButton">Simpan Transaksi</button>

        <!-- Tombol Bayar QR -->
        <div id="bayar-button" style="display: none;">
            <button type="button" class="btn btn-success" id="payButton" disabled>Bayar dengan QR</button>
        </div>
    </form>
</div>

<!-- Midtrans Snap JS -->
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
// Fungsi untuk memperbarui total harga dan memvalidasi stok
function updateTotal() {
    let total = 0;
    let validOrder = false;

    document.querySelectorAll('.jumlah-menu').forEach(input => {
        const price = parseFloat(input.dataset.price || 0);
        const quantity = parseInt(input.value || 0, 10);
        const id = input.dataset.id;
        const stockElement = document.getElementById('stok-' + id);
        const stock = parseInt(stockElement.innerText || 0, 10);

        if (quantity > 0) {
            if (quantity > stock) {
                input.nextElementSibling.innerHTML = 'Stok tidak mencukupi!';
                input.value = stock; // Batasi jumlah ke stok maksimal
            } else {
                input.nextElementSibling.innerHTML = ''; // Kosongkan pesan error
                total += price * quantity;
                validOrder = true;
            }
        }
    });

    document.getElementById('total_harga').value = total;
    document.getElementById('payButton').disabled = !validOrder;
}

// Fungsi untuk menampilkan atau menyembunyikan tombol Bayar berdasarkan metode pembayaran
function toggleBayarButton() {
    const metodePembayaran = document.getElementById('metode_pembayaran').value;
    const bayarButton = document.getElementById('bayar-button');
    const submitButton = document.getElementById('submitButton');

    if (metodePembayaran === 'qr') {
        bayarButton.style.display = 'block';
        submitButton.disabled = true;  // Nonaktifkan tombol simpan jika QR
    } else {
        bayarButton.style.display = 'none';
        submitButton.disabled = false; // Aktifkan tombol simpan jika Cash
    }
}

// Validasi form sebelum submit
document.getElementById('transaction-form').addEventListener('submit', function(event) {
    let isValid = true;
    const totalHarga = document.getElementById('total_harga').value;
    const namaPelanggan = document.getElementById('nama_pelanggan').value;

    // Validasi Nama Pelanggan dan Total Harga
    if (!namaPelanggan || !totalHarga) {
        alert('Harap isi Nama Pelanggan dan pilih menu!');
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Jika tidak valid, jangan kirim form
    }
});

// Proses pembayaran dengan Midtrans Snap
document.getElementById('payButton').addEventListener('click', () => {
    const totalHarga = document.getElementById('total_harga').value;
    const namaPelanggan = document.getElementById('nama_pelanggan').value;

    if (!totalHarga || !namaPelanggan) {
        alert('Harap isi Nama Pelanggan dan pilih menu!');
        return;
    }

    fetch('/api/create-transaction', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            total_harga: totalHarga,
            nama_pelanggan: namaPelanggan,
            metode_pembayaran: 'qr'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.token) {
            window.snap.pay(data.token, {
                onSuccess: function(result) {
                    alert("Pembayaran Berhasil!");
                    window.location.href = '/dashboard/cashier/payment';
                },
                onPending: function(result) {
                    alert("Pembayaran Tertunda!");
                },
                onError: function(result) {
                    alert("Pembayaran Gagal!");
                },
                onClose: function() {
                    alert("Pembayaran belum selesai, pastikan Anda menyelesaikan pembayaran.");
                }
            });
        } else {
            alert('Gagal membuat transaksi. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mencoba menghubungkan ke server. Coba lagi.');
    });
});

// Inisialisasi fungsi saat halaman dimuat
window.onload = function() {
    toggleBayarButton();
    updateTotal();
};

</script>
