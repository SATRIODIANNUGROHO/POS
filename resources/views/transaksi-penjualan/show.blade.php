@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($transaksi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID Detail</th>
                        <td>{{ $transaksi->detail_id }}</td>
                    </tr>
                    <tr>
                        <th>Penjualan ID</th>
                        <td>{{ $transaksi->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $transaksi->barang->barang_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp {{ number_format($transaksi->harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td>{{ $transaksi->jumlah }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('transaksi-penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush