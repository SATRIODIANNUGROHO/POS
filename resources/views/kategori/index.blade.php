@extends('layout.app')

@section('subtitle', 'Manage Kategori')
@section('content_header_title', 'Manage Kategori')
@section('content_header_subtitle', 'Daftar Kategori')

@section('content')
<div class="container">
    <a href="/POS/public/kategori/create" class="btn btn-primary mb-3">Add Kategori</a>
    <table id="kategoriTable" class="table table-striped">
        <thead>
            <tr>
                <th>Kode Kategori</th>
                <th>Nama Kategori</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{ $d->kategori_kode }}</td>
                <td>{{ $d->kategori_nama }}</td>
                <td>
                    <a href="/POS/public/kategori/edit/{{ $d->kategori_id }}" class="btn btn-warning">Edit</a>
                    <form action="/POS/public/kategori/{{ $d->kategori_id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection