<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_level extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Nama tabel sesuai dengan migrasi
    protected $primaryKey = 'level_id'; // Primary key tabel
    public $timestamps = true; // Aktifkan timestamps (created_at & updated_at)

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    /**
     * Relasi ke model m_user.
     * Satu level bisa memiliki banyak user.
     */
    public function users()
    {
        return $this->hasMany(m_user::class, 'level_id', 'level_id');
    }
}