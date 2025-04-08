<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang;
use App\Models\KategoriBarang;
use Yajra\DataTables\Facades\DataTables;

class DataBarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) ['title' => 'Data Barang', 'list' => ['Home', 'Data Barang']];
        $page = (object) ['title' => 'Daftar Barang'];
        $activeMenu = 'data-barang';
        $kategori = KategoriBarang::all();

        return view('data-barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function list(Request $request)
    {
        $data = DataBarang::with('kategori')->select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_jual', 'harga_beli');

        if ($request->kategori_id) {
            $data->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<a href="' . url('/data-barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/data-barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/data-barang/' . $barang->barang_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Barang', 'list' => ['Home', 'Data Barang', 'Tambah']];
        $page = (object) ['title' => 'Form Tambah Barang'];
        $activeMenu = 'data-barang';
        $kategori = KategoriBarang::all();

        return view('data-barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|max:20|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'kategori_id' => 'required|integer',
            'harga_jual'  => 'required|numeric',
            'harga_beli'  => 'required|numeric'
        ]);

        DataBarang::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_jual'  => $request->harga_jual,
            'harga_beli'  => $request->harga_beli
        ]);

        return redirect('/data-barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $barang = DataBarang::with('kategori')->where('barang_id', $id)->first();

        $breadcrumb = (object) ['title' => 'Detail Barang', 'list' => ['Home', 'Data Barang', 'Detail']];
        $page = (object) ['title' => 'Detail Barang'];
        $activeMenu = 'data-barang';

        return view('data-barang.show', compact('breadcrumb', 'page', 'barang', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $barang = DataBarang::where('barang_id', $id)->first();
        $kategori = KategoriBarang::all();

        $breadcrumb = (object) ['title' => 'Edit Barang', 'list' => ['Home', 'Data Barang', 'Edit']];
        $page = (object) ['title' => 'Form Edit Barang'];
        $activeMenu = 'data-barang';

        return view('data-barang.edit', compact('breadcrumb', 'page', 'barang', 'kategori', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_kode' => 'required|string|max:20|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'kategori_id' => 'required|integer',
            'harga_jual'  => 'required|numeric',
            'harga_beli'  => 'required|numeric'
        ]);

        $barang = DataBarang::where('barang_id', $id)->first();
        if (!$barang) {
            return redirect('/data-barang')->with('error', 'Data barang tidak ditemukan');
        }

        $barang->update([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_jual'  => $request->harga_jual,
            'harga_beli'  => $request->harga_beli
        ]);

        return redirect('/data-barang')->with('success', 'Data barang berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = DataBarang::where('barang_id', $id)->first();
        if (!$check) {
            return redirect('/data-barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            DataBarang::destroy($id);
            return redirect('/data-barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-barang')->with('error', 'Data barang gagal dihapus karena masih terkait dengan data lain');
        }
    }
}