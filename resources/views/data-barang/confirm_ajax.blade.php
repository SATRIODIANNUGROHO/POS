@empty($barang)
    <div id="modal-master" class="modal-dialog modal-md" role="document">
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
    <form action="{{ url('/data-barang/' . $barang->barang_id) }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data berikut?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">Kode Barang:</th>
                            <td class="col-8">{{ $barang->barang_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Nama Barang:</th>
                            <td>{{ $barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Kategori:</th>
                            <td>{{ $barang->kategori->kategori_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Harga Jual:</th>
                            <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Harga Beli:</th>
                            <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataTable.ajax.reload(); // reload datatable data-barang
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Terjadi kesalahan saat menghubungi server.'
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty