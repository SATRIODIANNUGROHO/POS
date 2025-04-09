@empty($barang)
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
                <a href="{{ url('/data-barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped mb-0">
                    <tr>
                        <th class="text-right col-4">Kode Barang :</th>
                        <td class="col-8">{{ $barang->barang_kode }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Nama Barang :</th>
                        <td>{{ $barang->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Kategori :</th>
                        <td>{{ $barang->kategori->kategori_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Harga Jual :</th>
                        <td>Rp{{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Harga Beli :</th>
                        <td>Rp{{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endempty