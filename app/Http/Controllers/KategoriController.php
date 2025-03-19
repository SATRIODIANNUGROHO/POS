<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\KategoriModel;
use App\DataTables\KategoriDataTable;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriModel::all();
        return view('kategori.index', ['data' => $kategori]);
    }
    /**
     * Show the form to create a new post.
     */
    public function create(): View
    {
        return view('kategori.create');
    }

    /**
     * Store a new post.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode' => 'bail|required|unique:m_kategori,kategori_kode|max:10',
            'kategori_nama' => 'bail|required|max:100',
        ]);
    
        // The post is valid...
    
        return redirect('/kategori');
    }    
}