<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-user', function ($user, $request) {
            return $user->id === $request->id;
        });
        Gate::define('update-user', function ($user, $request) {
            return $user->id === $request->id;
        });
        Gate::define('delete-user', function ($user, $request) {
            return $user->id === $request->id;
        });
    }
}
