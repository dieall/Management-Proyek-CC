<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Committee;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitteePolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Committee $committee): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Committee $committee): bool
    {
        return $user->isSuperAdmin();
    }
}
