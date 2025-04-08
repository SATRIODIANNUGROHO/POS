<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StokBarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Stok Barang',
            'list'  => ['Home', 'Stok Barang']
        ];

        $page = (object)[
            'title' => 'Daftar Stok Barang'
        ];

        $activeMenu = 'stok-barang';

        return view('stok-barang.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = StokBarang::with('barang')->select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok-barang/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok-barang/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok-barang/' . $stok->stok_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Stok Barang',
            'list'  => ['Home', 'Stok Barang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Stok Barang'
        ];

        $activeMenu = 'stok-barang';
        $barang = DataBarang::all();

        return view('stok-barang.create', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'    => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah'  => 'required|integer',
        ]);

        StokBarang::create([
            'barang_id'    => $request->barang_id,
            'user_id'      => Auth::id(), // ambil dari user login
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah'  => $request->stok_jumlah,
        ]);

        return redirect('/stok-barang')->with('success', 'Stok barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $stok = StokBarang::with('barang')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Stok Barang',
            'list'  => ['Home', 'Stok Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Stok Barang'
        ];

        $activeMenu = 'stok-barang';

        return view('stok-barang.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $stok = StokBarang::find($id);
        $barang = DataBarang::all();

        $breadcrumb = (object)[
            'title' => 'Edit Stok Barang',
            'list'  => ['Home', 'Stok Barang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Form Edit Stok Barang'
        ];

        $activeMenu = 'stok-barang';

        return view('stok-barang.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_id'    => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah'  => 'required|integer',
        ]);

        $stok = StokBarang::find($id);
        if (!$stok) {
            return redirect('/stok-barang')->with('error', 'Data stok barang tidak ditemukan');
        }

        $stok->update([
            'barang_id'    => $request->barang_id,
            'user_id'      => Auth::id(), // update dengan user saat ini
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah'  => $request->stok_jumlah,
        ]);

        return redirect('/stok-barang')->with('success', 'Data stok barang berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $check = StokBarang::find($id);
        if (!$check) {
            return redirect('/stok-barang')->with('error', 'Data stok barang tidak ditemukan');
        }

        try {
            StokBarang::destroy($id);
            return redirect('/stok-barang')->with('success', 'Data stok barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/stok-barang')->with('error', 'Data stok barang gagal dihapus');
        }
    }
}