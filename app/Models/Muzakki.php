<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
