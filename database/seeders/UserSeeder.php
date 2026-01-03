<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@masjid.com',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ketua Takmir',
                'email' => 'ketua@masjid.com',
                'password' => Hash::make('ketua123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Wakil Ketua Takmir',
                'email' => 'wakilketua@masjid.com',
                'password' => Hash::make('wakilketua123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sekretaris',
                'email' => 'sekretaris@masjid.com',
                'password' => Hash::make('sekretaris123'),
                'role' => 'member',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@masjid.com',
                'password' => Hash::make('bendahara123'),
                'role' => 'member',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('Users seeded successfully with roles!');
    }
}
