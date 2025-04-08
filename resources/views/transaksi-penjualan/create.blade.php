@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('transaksi-penjualan') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="penjualan_id">Penjualan ID</label>
                    <input type="text" name="penjualan_id" id="penjualan_id" class="form-control"
                        value="{{ old('penjualan_id') }}" required>
                </div>

                <div class="form-group">
                    <label for="barang_id">Pilih Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}" {{ old('barang_id') == $item->barang_id ? 'selected' : '' }}>
                                {{ $item->barang_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control"
                        value="{{ old('harga') }}" required>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                        value="{{ old('jumlah') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('transaksi-penjualan') }}" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush