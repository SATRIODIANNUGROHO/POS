<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Models\DataBarang;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
        $data = StokBarang::with(['barang', 'user'])
            ->select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah');
    
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user_nama', function ($stok) {
                return $stok->user ? $stok->user->nama : '-';
            })
            ->addColumn('aksi', function ($stok) {
                $btn  = '<button onclick="modalAction(\'' . url('/stok-barang/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok-barang/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok-barang/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
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

    public function create_ajax()
    {
        $barangList = DataBarang::all(); // yang kamu sudah kirim ke view
        $userList = UserModel::all(); // ambil semua user
    
        return view('stok-barang.create_ajax', compact('barangList', 'userList'));
    }
    

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'   => 'required|integer',
                'user_id'     => 'required|integer',
                'stok_tanggal'=> 'required|date',
                'stok_jumlah' => 'required|integer|min:1'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // $request['user_id'] = auth()->id(); // asumsikan user login

            StokBarang::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $stok = StokBarang::find($id);
        $barangList = DataBarang::select('barang_id', 'barang_nama')->get();

        return view('stok-barang.edit_ajax', compact('stok', 'barangList'));
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'   => 'required|integer',
                'stok_tanggal'=> 'required|date',
                'stok_jumlah' => 'required|integer|min:1'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $stok = StokBarang::find($id);
            if ($stok) {
                $stok->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil diupdate'
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
        $stok = StokBarang::with('barang')->find($id);
        return view('stok-barang.confirm_ajax', compact('stok'));
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokBarang::find($id);
            if ($stok) {
                $stok->delete();
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

    public function show_ajax(string $id)
    {
        $stok = StokBarang::with('barang')->find($id);
        return view('stok-barang.show_ajax', compact('stok'));
    }
}