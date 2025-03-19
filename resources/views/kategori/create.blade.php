@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create')

{{-- Content body: main page content --}}
@section('content')
<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Buat kategori baru</h3>
        </div>

        <form method="POST" action="../kategori">
            @csrf
            {{-- Menampilkan pesan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="kodeKategori">Kode Kategori</label>
                    <input type="text" class="form-control @error('kategori_kode') is-invalid @enderror" 
                        id="kodeKategori" name="kategori_kode" placeholder="Masukkan kode kategori"
                        value="{{ old('kategori_kode') }}">

                    @error('kategori_kode')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="namaKategori">Nama Kategori</label>
                    <input type="text" class="form-control @error('kategori_nama') is-invalid @enderror" 
                        id="namaKategori" name="kategori_nama" placeholder="Masukkan nama kategori"
                        value="{{ old('kategori_nama') }}">

                    @error('kategori_nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection