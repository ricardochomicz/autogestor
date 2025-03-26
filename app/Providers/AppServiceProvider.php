<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $this->configModel();

        Gate::define('is-admin', function ($user) {
            return $user->admin_id == NULL;
        });

        Gate::before(function ($user, $permission) {
            if ($user->hasPermission($permission)) {
                return true; // O usuário pode passar, sem precisar de outras verificações
            }
        });
    }

    /**
     * Config the model for unguard fillable attributes.
     */
    private function configModel(): void
    {
        Model::unguard();
    }
}
