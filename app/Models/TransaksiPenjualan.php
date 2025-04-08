<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    public $timestamps = true; // Aktifkan timestamps (created_at & updated_at)

    protected $primaryKey = 'penjualan_id'; // Primary key tabel

    protected $table = 't_penjualan'; 

    protected $fillable = [
        'penjualan_id', 
        'user_id', // Foreign key ke data user
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
    ];

    public function user() 
    {
        return $this->belongsTo(m_user::class, 'user_id');
    }
}
