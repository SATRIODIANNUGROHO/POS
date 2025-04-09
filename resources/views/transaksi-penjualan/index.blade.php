@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('transaksi-penjualan/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_transaksi">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Penjualan ID</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function () {
        $('#table_transaksi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('transaksi-penjualan/list') }}",
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    // Tambah filter tambahan di sini jika dibutuhkan
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'detail_id' },
                { data: 'penjualan_id', name: 'penjualan_id' },
                { data: 'barang.barang_nama', name: 'barang.barang_nama' },
                { data: 'harga', name: 'harga' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush