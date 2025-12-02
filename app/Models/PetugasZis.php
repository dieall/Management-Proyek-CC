<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasZis extends Model
{
    use HasFactory;

    protected $table = 'petugas_zis';
    protected $primaryKey = 'id_petugas_zis';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'password',
        'tgl_daftar',
        'id_user',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'tgl_daftar' => 'datetime',
        ];
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
