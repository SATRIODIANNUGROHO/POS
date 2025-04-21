<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelUser extends Model
{
    use HasFactory;

    protected $table = 'm_level';
    
    protected $primaryKey = 'level_id'; // Primary key tabel
    
    public $timestamps = true; // Aktifkan timestamps (created_at & updated_at)
    
    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    public function users()
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }

}