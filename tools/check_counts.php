<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Position;
use App\Models\Committee;
use App\Models\JobResponsibility;
use App\Models\DutySchedule;
use App\Models\TaskAssignment;
use App\Models\OrganizationalStructure;
use App\Models\Voting;
use App\Models\Vote;

echo "positions: " . Position::count() . PHP_EOL;
echo "committees: " . Committee::count() . PHP_EOL;
echo "job_responsibilities: " . JobResponsibility::count() . PHP_EOL;
echo "duty_schedules: " . DutySchedule::count() . PHP_EOL;
echo "task_assignments: " . TaskAssignment::count() . PHP_EOL;
echo "organizational_structures: " . OrganizationalStructure::count() . PHP_EOL;
echo "votings: " . Voting::count() . PHP_EOL;
echo "votes: " . Vote::count() . PHP_EOL;
