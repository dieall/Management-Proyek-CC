<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Import Model Muzakki
use App\Models\Muzakki; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nama_lengkap',
        'email',
        'no_hp',
        'alamat',
        'password',
        'role',
        'status_aktif',
        'tanggal_daftar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'tanggal_daftar' => 'datetime',
        ];
    }

    // Relations
    public function petugasZis()
    {
        return $this->hasOne(PetugasZis::class, 'id_user');
    }
    
    // **RELASI BARU: Diperlukan untuk Pendaftaran Muzakki**
    public function muzakkiProfile()
    {
        // Relasi 1-ke-1, menggunakan kolom 'user_id' di tabel 'muzakki'
        return $this->hasOne(Muzakki::class, 'user_id', 'id'); 
    }
}