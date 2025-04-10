@empty($data)
    <div id="modal-master" class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/transaksi-penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped mb-0">
                    <tr>
                        <th class="text-right col-4">Detail ID :</th>
                        <td class="col-8">{{ $data->detail_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Penjualan ID :</th>
                        <td>{{ $data->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Barang :</th>
                        <td>{{ $data->barang->barang_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Harga :</th>
                        <td>Rp {{ number_format($data->harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Jumlah :</th>
                        <td>{{ $data->jumlah }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endempty