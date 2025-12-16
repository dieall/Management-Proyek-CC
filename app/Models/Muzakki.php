<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Muzakki extends Model
{
    use HasFactory;

    protected $table = 'muzakki';
    protected $primaryKey = 'id_muzakki';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'password',
        'tgl_daftar',
        'user_id', // WAJIB: Kolom baru dari migrasi
        'status_pendaftaran', // WAJIB: Kolom baru dari migrasi
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'tgl_daftar' => 'datetime',
        ];
    }

    // Relations
    public function zismasuk()
    {
        return $this->hasMany(ZisMasuk::class, 'id_muzakki');
    }
    
    // **RELASI BARU: Relasi terbalik ke User**
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Authenticate a Muzakki using username (nama/no_hp) and password. (BARU)
     */
    public static function authenticate($username, $password)
    {
        $muzakki = self::where('no_hp', $username)
            ->orWhere('nama', $username)
            ->first();
            
        if ($muzakki && Hash::check($password, $muzakki->password)) { 
            return $muzakki;
        }
        
        return null;
    }
}