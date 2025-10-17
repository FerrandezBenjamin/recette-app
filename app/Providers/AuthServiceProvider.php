<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;

use App\Models\Dish;
use App\Policies\DishPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Dish::class => DishPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
