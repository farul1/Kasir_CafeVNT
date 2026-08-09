<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <form action="/dashboard/menu" method="post" enctype="multipart/form-data" id="menu-form">
                @csrf
                <h3 class="box-title">Tambah Menu</h3>

                <!-- Nama Menu -->
                <div class="mb-2">
                    <label for="nama_menu" class="form-label mb-1">Nama Menu</label>
                    <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" name="nama_menu" id="nama_menu" placeholder="Masukkan Nama Menu" autocomplete="off" required>
                    @error('nama_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="mb-2">
                    <label for="harga" class="form-label mb-1">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" id="harga" placeholder="Masukkan Harga" min="1" required>
                    </div>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-2">
                    <label for="deskripsi" class="form-label mb-1">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" placeholder="Masukkan Deskripsi" rows="3" required></textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ketersediaan -->
                <div class="mb-2">
                    <label for="ketersediaan" class="form-label mb-1">Ketersediaan</label>
                    <input type="number" class="form-control @error('ketersediaan') is-invalid @enderror" name="ketersediaan" id="ketersediaan" placeholder="Masukkan Ketersediaan" min="0" required>
                    @error('ketersediaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gambar Menu -->
                <div class="mb-2">
                    <label for="gambar_menu" class="form-label mb-1">Gambar Menu</label>
                    <input type="file" class="form-control @error('gambar_menu') is-invalid @enderror" name="gambar_menu" id="gambar_menu" accept="image/*" required>
                    @error('gambar_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="d-flex">
                    <button type="submit" class="btn btn-success text-white shadow-none">Tambahkan</button>
                    <a href="/dashboard/menu" class="btn btn-danger text-white shadow-none ms-2">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('menu-form').addEventListener('submit', function(event) {
        const harga = parseFloat(document.getElementById('harga').value);
        const ketersediaan = parseInt(document.getElementById('ketersediaan').value);

        if (harga <= 0 || ketersediaan < 0) {
            event.preventDefault();
            alert('Harga harus lebih dari 0 dan ketersediaan tidak boleh kurang dari 0');
        }
    });
</script>
