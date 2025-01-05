<form action="{{ route('cashier.destroy', $transaksi->id) }}" method="post" class="d-inline">
    @csrf
    @method('delete')
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white shadow-none" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger text-white shadow-none">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</form>
