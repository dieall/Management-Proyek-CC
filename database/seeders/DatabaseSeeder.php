<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PositionSeeder::class,
            CommitteeSeeder::class,
            JobResponsibilitySeeder::class,
            PositionHistorySeeder::class,
            DutyScheduleSeeder::class,
            TaskAssignmentSeeder::class,
            OrganizationalStructureSeeder::class,
        ]);
    }
}
