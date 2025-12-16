<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Mustahik extends Model
{
    use HasFactory;

    protected $table = 'mustahik';
    protected $primaryKey = 'id_mustahik';

    protected $fillable = [
        'nama',
        'alamat',
        'kategori_mustahik',
        'no_hp',
        'surat_dtks',
        'status',
        'status_verifikasi',
        'password', 
        'tgl_daftar',
    ];

    protected function casts(): array
    {
        return [
            'tgl_daftar' => 'datetime',
        ];
    }

    // Relations
    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_mustahik');
    }
    
    /**
     * Authenticate a Mustahik using username (nama/no_hp) and password. (BARU)
     */
    public static function authenticate($username, $password)
    {
        $mustahik = self::where('no_hp', $username)
            ->orWhere('nama', $username)
            ->first();
            
        if ($mustahik && Hash::check($password, $mustahik->password)) { 
            return $mustahik;
        }
        
        return null;
    }
}