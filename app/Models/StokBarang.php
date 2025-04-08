<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    public $timestamps = true; // Aktifkan timestamps (created_at & updated_at)

    protected $primaryKey = 'stok_id'; // Primary key tabel

    protected $table = 't_stok'; 

    protected $fillable = [
        'barang_id', // Foreign key ke data barang
        'user_id',
        'stok_tanggal',
        'stok_jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'barang_id');
    }
}