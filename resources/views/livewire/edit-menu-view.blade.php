<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <form action="/dashboard/menu/{{ $menu->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <h3 class="box-title">Edit Menu</h3>

                <!-- Nama Menu -->
                <div class="profile-wrapper mb-2">
                    <label class="form-label mb-1" for="nama_menu">Nama Menu</label>
                    <input type="text" class="form-control" name="nama_menu" id="nama_menu"
                           placeholder="Masukkan Nama Menu" autocomplete="off"
                           value="{{ old('nama_menu', $menu->nama_menu) }}">
                </div>
                @error('nama_menu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Harga -->
                <label class="form-label mb-1" for="harga">Harga</label>
                <div class="input-group profile-wrapper mb-2">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                    <input type="number" class="form-control" name="harga" id="harga"
                           placeholder="Masukkan Harga" autocomplete="off"
                           value="{{ old('harga', $menu->harga) }}" aria-describedby="basic-addon1">
                </div>
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Deskripsi -->
                <div class="profile-wrapper mb-2">
                    <label class="form-label mb-1" for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi"
                              placeholder="Masukkan Deskripsi" rows="3">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                </div>
                @error('deskripsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Ketersediaan -->
                <div class="profile-wrapper mb-2">
                    <label class="form-label mb-1" for="ketersediaan">Ketersediaan</label>
                    <input type="number" class="form-control" name="ketersediaan" id="ketersediaan"
                           placeholder="Masukkan Ketersediaan"
                           value="{{ old('ketersediaan', $menu->ketersediaan) }}">
                </div>
                @error('ketersediaan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Gambar (Opsional) -->
                <div class="profile-wrapper mb-2">
                    <label class="form-label mb-1" for="gambar_menu">Gambar Menu</label>
                    <input type="file" class="form-control" name="gambar_menu" id="gambar_menu">
                    @if($menu->gambar_menu)
                        <img src="{{ asset('storage/' . $menu->gambar_menu) }}"
                             alt="Gambar Menu" style="max-width: 150px; margin-top: 10px;">
                    @endif
                </div>
                @error('gambar_menu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Tombol -->
                <button class="btn btn-primary text-white shadow-none mt-2">Edit</button>
                <a href="/dashboard/menu" class="btn btn-danger text-white shadow-none mt-2 ms-2">Kembali</a>
            </form>
        </div>
    </div>
</div>
