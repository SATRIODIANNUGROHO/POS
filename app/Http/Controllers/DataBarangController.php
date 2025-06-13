<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang;
use App\Models\KategoriBarang;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // Jika ingin menambahkan filter berdasarkan kategori_id
        if ($request->kategori_id) {
            $data->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn  = '<button onclick="modalAction(\'' . url('/data-barang/' . $barang->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/data-barang/' . $barang->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/data-barang/' . $barang->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
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

    public function create_ajax()
    {
        $kategoriList = KategoriBarang::select('kategori_id', 'kategori_nama')->get();
        return view('data-barang.create_ajax', compact('kategoriList'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|max:100',
                'kategori_id' => 'required|exists:m_kategori,kategori_id',
                'harga_jual' => 'required|numeric|min:0',
                'harga_beli' => 'required|numeric|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            DataBarang::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $barang = DataBarang::find($id);
        $kategoriList = KategoriBarang::all();

        return view('data-barang.edit_ajax', compact('barang', 'kategoriList'));
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama' => 'required|string|max:100',
                'kategori_id' => 'required|exists:m_kategori,kategori_id',
                'harga_jual' => 'required|numeric|min:0',
                'harga_beli' => 'required|numeric|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $barang = DataBarang::find($id);

            if ($barang) {
                $barang->update($request->all());

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
        $barang = DataBarang::find($id);
        return view('data-barang.confirm_ajax', compact('barang'));
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = DataBarang::find($id);

            if ($barang) {
                $barang->delete();

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
            $barang = DataBarang::with('kategori')->find($id);
            return view('data-barang.show_ajax', compact('barang'));
        }

        return redirect('/');
    }
    public function import()
    {
        return view('data-barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang');  // ambil file dari request

            $reader = IOFactory::createReader('Xlsx');  // load reader file excel
            $reader->setReadDataOnly(true);             // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true);   // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'kategori_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli' => $value['D'],
                            'harga_jual' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    DataBarang::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/data-barang');
    }

    public function export_excel()
    {
        // ambil data barang yang akan di export
        $barang = DataBarang::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);    // bold header

        $no = 1;             // nomor data dimulai dari 1
        $baris = 2;          // baris data dimulai dari baris ke 2
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->barang_kode);
            $sheet->setCellValue('C' . $baris, $value->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->harga_beli);
            $sheet->setCellValue('E' . $baris, $value->harga_jual);
            $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama); // ambil nama kategori
            $baris++;
            $no++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data Barang'); // set title sheet

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    } // end function export_excel

    public function export_pdf()
    {
        $barang = DataBarang::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->orderBy('barang_kode')
            ->with('kategori')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('data-barang.export_pdf', ['barang' => $barang]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Barang ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
