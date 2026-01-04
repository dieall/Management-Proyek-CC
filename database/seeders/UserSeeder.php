<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@masjid.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@masjid.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // User/Pengurus
        User::create([
            'name' => 'Pengurus',
            'email' => 'pengurus@masjid.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
