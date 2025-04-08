<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'm_kategori'; 
    
    protected $primaryKey = 'kategori_id'; // Primary key tabel
    
    public $timestamps = true; // Aktifkan timestamps (created_at & updated_at)

    protected $fillable = [
        'kategori_kode',
        'kategori_nama',
    ];
}