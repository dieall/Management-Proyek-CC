<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Committee;

$committees = Committee::all();
foreach ($committees as $c) {
    echo "- {$c->full_name} | position_id={$c->position_id} | photo={$c->photo_path} | cv={$c->cv_path}\n";
}
