<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualanDetail;
use App\Models\DataBarang;
use Yajra\DataTables\Facades\DataTables;

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
        $data = TransaksiPenjualanDetail::with('barang')->select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah');

        if ($request->barang_id) {
            $data->where('barang_id', $request->barang_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($transaksi) {
                $btn = '<a href="' . url('/transaksi-penjualan/' . $transaksi->detail_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/transaksi-penjualan/' . $transaksi->detail_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/transaksi-penjualan/' . $transaksi->detail_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus transaksi ini?\');">Hapus</button></form>';
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
}