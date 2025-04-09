<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) ['title' => 'Kategori Barang', 'list' => ['Home', 'Kategori Barang']];
        $page = (object) ['title' => 'Daftar Kategori Barang'];
        $activeMenu = 'kategori-barang';

        return view('kategori-barang.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = KategoriBarang::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori-barang/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori-barang/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori-barang/' . $kategori->kategori_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Kategori Barang', 'list' => ['Home', 'Kategori Barang', 'Tambah']];
        $page = (object) ['title' => 'Form Tambah Kategori Barang'];
        $activeMenu = 'kategori-barang';

        return view('kategori-barang.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama',
        ]);

        KategoriBarang::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori-barang')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show(string $id)
    {
        $kategori = KategoriBarang::find($id);

        $breadcrumb = (object) ['title' => 'Detail Kategori Barang', 'list' => ['Home', 'Kategori Barang', 'Detail']];
        $page = (object) ['title' => 'Detail Kategori Barang'];
        $activeMenu = 'kategori-barang';

        return view('kategori-barang.show', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $kategori = KategoriBarang::find($id);

        $breadcrumb = (object) ['title' => 'Edit Kategori Barang', 'list' => ['Home', 'Kategori Barang', 'Edit']];
        $page = (object) ['title' => 'Edit Kategori Barang'];
        $activeMenu = 'kategori-barang';

        return view('kategori-barang.edit', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama,' . $id . ',kategori_id',
        ]);

        $kategori = KategoriBarang::find($id);
        if (!$kategori) {
            return redirect('/kategori-barang')->with('error', 'Data kategori tidak ditemukan');
        }

        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori-barang')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriBarang::find($id);
        if (!$kategori) {
            return redirect('/kategori-barang')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriBarang::destroy($id);
            return redirect('/kategori-barang')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori-barang')->with('error', 'Data kategori gagal dihapus karena masih terkait dengan data lain');
        }
    }

    public function create_ajax()
    {
        return view('kategori-barang.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KategoriBarang::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kategori barang berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $kategori = KategoriBarang::find($id);

        return view('kategori-barang.edit_ajax', compact('kategori'));
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $kategori = KategoriBarang::find($id);

            if ($kategori) {
                $kategori->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $kategori = KategoriBarang::find($id);

        return view('kategori-barang.confirm_ajax', compact('kategori'));
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriBarang::find($id);

            if ($kategori) {
                $kategori->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function show_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriBarang::find($id);

            return view('kategori-barang.show_ajax', compact('kategori'));
        }

        return redirect('/');
    }
}