<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;

    public $timestamps = true; // Aktifkan timestamps (created_at & updated_at)

    protected $primaryKey = 'barang_id'; // Primary key tabel

    protected $table = 'm_barang';

    protected $fillable = [
        'kategori_id', // Foreign key ke kategori barang
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }
}