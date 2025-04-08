<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 't_penjualan_detail';
    
    protected $primaryKey = 'detail_id'; // Primary key tabel
    
    public $timestamps = true; // Aktifkan timestamps (created_at & updated_at)

    protected $fillable = [
        'penjualan_id', // Foreign key ke transaksi penjualan
        'barang_id', // Foreign key ke data barang
        'harga',
        'jumlah',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'penjualan_id');
    }    

    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'barang_id');
    }
}