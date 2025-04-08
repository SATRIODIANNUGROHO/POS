<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelUser;
use Yajra\DataTables\Facades\DataTables;

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
        $data = LevelUser::select('level_id', 'level_kode', 'level_nama');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn = '<a href="' . url('/level-user/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/level-user/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level-user/' . $level->level_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // beri tahu DataTables kalau kolom ini HTML
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
}
