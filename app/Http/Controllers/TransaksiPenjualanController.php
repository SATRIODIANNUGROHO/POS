<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\TransaksiPenjualanDetail;
use App\Models\DataBarang;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) ['title' => 'Transaksi Penjualan', 'list' => ['Home', 'Transaksi Penjualan']];
        $page = (object) ['title' => 'Daftar Transaksi Penjualan'];
        $activeMenu = 'transaksi-penjualan';

        return view('transaksi-penjualan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = TransaksiPenjualanDetail::with('barang')
            ->select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah');
    
        // Filter berdasarkan barang_id jika dikirim dari frontend (opsional)
        if ($request->barang_id) {
            $data->where('barang_id', $request->barang_id);
        }
    
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('barang_nama', function ($row) {
                return $row->barang->barang_nama ?? '-';
            })
            ->addColumn('aksi', function ($transaksi) {
                $btn  = '<button onclick="modalAction(\'' . url('/transaksi-penjualan/' . $transaksi->detail_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi-penjualan/' . $transaksi->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi-penjualan/' . $transaksi->detail_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }    

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Transaksi', 'list' => ['Home', 'Transaksi Penjualan', 'Tambah']];
        $page = (object) ['title' => 'Form Tambah Transaksi'];
        $activeMenu = 'transaksi-penjualan';
        $barang = DataBarang::all();

        return view('transaksi-penjualan.create', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|string|max:50',
            'barang_id'    => 'required|integer',
            'harga'        => 'required|numeric',
            'jumlah'       => 'required|integer'
        ]);

        TransaksiPenjualanDetail::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id'    => $request->barang_id,
            'harga'        => $request->harga,
            'jumlah'       => $request->jumlah
        ]);

        return redirect('/transaksi-penjualan')->with('success', 'Transaksi berhasil disimpan');
    }

    public function show(string $id)
    {
        $transaksi = TransaksiPenjualanDetail::with('barang')->find($id);

        $breadcrumb = (object) ['title' => 'Detail Transaksi', 'list' => ['Home', 'Transaksi Penjualan', 'Detail']];
        $page = (object) ['title' => 'Detail Transaksi Penjualan'];
        $activeMenu = 'transaksi-penjualan';

        return view('transaksi-penjualan.show', compact('breadcrumb', 'page', 'transaksi', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $transaksi = TransaksiPenjualanDetail::find($id);
        $barang = DataBarang::all();

        $breadcrumb = (object) ['title' => 'Edit Transaksi', 'list' => ['Home', 'Transaksi Penjualan', 'Edit']];
        $page = (object) ['title' => 'Form Edit Transaksi'];
        $activeMenu = 'transaksi-penjualan';

        return view('transaksi-penjualan.edit', compact('breadcrumb', 'page', 'transaksi', 'barang', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'penjualan_id' => 'required|string|max:50',
            'barang_id'    => 'required|integer',
            'harga'        => 'required|numeric',
            'jumlah'       => 'required|integer'
        ]);

        $transaksi = TransaksiPenjualanDetail::find($id);
        if (!$transaksi) {
            return redirect('/transaksi-penjualan')->with('error', 'Data transaksi tidak ditemukan');
        }

        $transaksi->update([
            'penjualan_id' => $request->penjualan_id,
            'barang_id'    => $request->barang_id,
            'harga'        => $request->harga,
            'jumlah'       => $request->jumlah
        ]);

        return redirect('/transaksi-penjualan')->with('success', 'Transaksi berhasil diubah');
    }

    public function destroy(string $id)
    {
        $transaksi = TransaksiPenjualanDetail::find($id);
        if (!$transaksi) {
            return redirect('/transaksi-penjualan')->with('error', 'Data transaksi tidak ditemukan');
        }

        try {
            TransaksiPenjualanDetail::destroy($id);
            return redirect('/transaksi-penjualan')->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/transaksi-penjualan')->with('error', 'Transaksi gagal dihapus');
        }
    }

    public function create_ajax()
    {
        $barangList = DataBarang::select('barang_id', 'barang_nama')->get();
        $penjualanList = TransaksiPenjualan::select('penjualan_id')->get();
    
        return view('transaksi-penjualan.create_ajax', compact('barangList', 'penjualanList'));
    }
    
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|integer',
                'barang_id'    => 'required|integer',
                'harga'        => 'required|numeric',
                'jumlah'       => 'required|integer|min:1'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            TransaksiPenjualanDetail::create($request->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Data transaksi penjualan berhasil disimpan'
            ]);
        }
    
        return redirect('/');
    }
    
    public function edit_ajax(string $id)
    {
        $data = TransaksiPenjualanDetail::find($id);
        $barangList = DataBarang::select('barang_id', 'barang_nama')->get();
        $penjualanList = TransaksiPenjualan::select('penjualan_id')->get();
    
        return view('transaksi-penjualan.edit_ajax', compact('data', 'barangList', 'penjualanList'));
    }
    
    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|integer',
                'barang_id'    => 'required|integer',
                'harga'        => 'required|numeric',
                'jumlah'       => 'required|integer|min:1'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            $data = TransaksiPenjualanDetail::find($id);
    
            if ($data) {
                $data->update($request->all());
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
        $data = TransaksiPenjualanDetail::with('barang')->find($id);
    
        return view('transaksi-penjualan.confirm_ajax', compact('data'));
    }
    
    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $data = TransaksiPenjualanDetail::find($id);
    
            if ($data) {
                $data->delete();
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
            $data = TransaksiPenjualanDetail::with('barang')->find($id);
    
            return view('transaksi-penjualan.show_ajax', compact('data'));
        }
    
        return redirect('/');
    }    
}