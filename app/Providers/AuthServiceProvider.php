<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Daftarkan semua policy di sini
        \App\Models\User::class         => \App\Policies\UserPolicy::class,
        \App\Models\Committee::class    => \App\Policies\CommitteePolicy::class,
        // Jika nanti ada model lain yang butuh policy, tambahkan di sini
        // Contoh: \App\Models\Position::class => \App\Policies\PositionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Contoh Gate tambahan jika diperlukan (opsional)
        // Gate::define('manage-users', function ($user) {
        //     return $user->isSuperAdmin();
        // });

        // Gate::define('create-committee', function ($user) {
        //     return $user->isSuperAdmin();
        // });
    }
}
