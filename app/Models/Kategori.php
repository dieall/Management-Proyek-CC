<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function jamaah()
    {
        return $this->belongsToMany(Jamaah::class, 'kategori_jamaah', 'id_kategori', 'id_jamaah')
                    ->withPivot(['status_aktif', 'periode']);
    }
}