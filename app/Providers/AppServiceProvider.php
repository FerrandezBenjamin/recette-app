<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Dish;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Policies\DishPolicy;

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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Dish::class, DishPolicy::class);
    }
}
