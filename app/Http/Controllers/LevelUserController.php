<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelUser;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LevelUserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) ['title' => 'Level User', 'list' => ['Home', 'Level User']];
        $page = (object) ['title' => 'Daftar Level User'];
        $activeMenu = 'level-user';

        return view('level-user.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $level = LevelUser::select('level_id', 'level_kode', 'level_nama');
    
        // Jika ingin menambahkan filter (optional)
        if ($request->level_kode) {
            $level->where('level_kode', 'like', '%' . $request->level_kode . '%');
        }
    
        return DataTables::of($level)
            ->addIndexColumn() // tambahkan kolom index
            ->addColumn('aksi', function ($lvl) {
                $btn  = '<button onclick="modalAction(\'' . url('/level-user/' . $lvl->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level-user/' . $lvl->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level-user/' . $lvl->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // beritahu DataTables bahwa kolom aksi berupa HTML
            ->make(true);
    }    

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Level User', 'list' => ['Home', 'Level User', 'Tambah']];
        $page = (object) ['title' => 'Form Tambah Level User'];
        $activeMenu = 'level-user';
    
        return view('level-user.create', compact('breadcrumb', 'page', 'activeMenu'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);
    
        LevelUser::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
    
        return redirect('/level-user')->with('success', 'Data berhasil disimpan');
    }
    
    public function show(string $id)
    {
        $level = LevelUser::find($id); // ambil data level berdasarkan ID
    
        $breadcrumb = (object) [
            'title' => 'Detail Level User',
            'list'  => ['Home', 'Level User', 'Detail']
        ];
    
        $page = (object) [
            'title' => 'Detail Level User'
        ];
    
        $activeMenu = 'level-user'; // set menu aktif
    
        return view('level-user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }    
    
    public function edit(string $id)
    {
        $level = LevelUser::find($id); // ambil data level berdasarkan ID
    
        $breadcrumb = (object) [
            'title' => 'Edit Level User',
            'list'  => ['Home', 'Level User', 'Edit']
        ];
    
        $page = (object) [
            'title' => 'Edit Level User'
        ];
    
        $activeMenu = 'level-user'; // set menu yang sedang aktif
    
        return view('level-user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }    
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);
    
        $level = LevelUser::find($id);
        if (!$level) {
            return redirect('/level-user')->with('error', 'Data level user tidak ditemukan');
        }
    
        $level->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
    
        return redirect('/level-user')->with('success', 'Data level user berhasil diubah');
    }    
    
    public function destroy(string $id)
    {
        $check = LevelUser::find($id);
        if (!$check) {
            return redirect('/level-user')->with('error', 'Data level user tidak ditemukan');
        }
    
        try {
            LevelUser::destroy($id);
            return redirect('/level-user')->with('success', 'Data level user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level-user')->with('error', 'Data level user gagal dihapus karena masih terkait dengan data lain');
        }
    }

    public function create_ajax()
    {
        return view('level-user.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            LevelUser::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data level user berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $level = LevelUser::find($id);

        return view('level-user.edit_ajax', compact('level'));
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $level = LevelUser::find($id);

            if ($level) {
                $level->update($request->all());
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
        $level = LevelUser::find($id);

        return view('level-user.confirm_ajax', compact('level'));
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelUser::find($id);

            if ($level) {
                $level->delete();
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
}
