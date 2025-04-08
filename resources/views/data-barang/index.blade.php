@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('data-barang/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="form-group mb-3">
                <label for="filter_kategori">Filter Kategori:</label>
                <select name="kategori_id" id="filter_kategori" class="form-control form-control-sm">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
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
        const table = $('#table_barang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('data-barang/list') }}",
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.kategori_id = $('#filter_kategori').val();
                }
            },
            columns: [
                { data: 'barang_id', name: 'barang_id' },
                { data: 'barang_kode', name: 'barang_kode' },
                { data: 'barang_nama', name: 'barang_nama' },
                { data: 'kategori.kategori_nama', name: 'kategori.kategori_nama' },
                { data: 'harga_jual', name: 'harga_jual' },
                { data: 'harga_beli', name: 'harga_beli' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });

        // Filter kategori
        $('#filter_kategori').on('change', function () {
            table.ajax.reload();
        });
    });
</script>
@endpush