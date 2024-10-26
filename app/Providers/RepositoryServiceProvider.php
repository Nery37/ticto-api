<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\AddressRepository;
use App\Repositories\AddressRepositoryEloquent;
use App\Repositories\PasswordResetRepository;
use App\Repositories\PasswordResetRepositoryEloquent;
use App\Repositories\UserCheckInRepository;
use App\Repositories\UserCheckInRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register() {}

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(PasswordResetRepository::class, PasswordResetRepositoryEloquent::class);
        $this->app->bind(UserCheckInRepository::class, UserCheckInRepositoryEloquent::class);
        $this->app->bind(AddressRepository::class, AddressRepositoryEloquent::class);
    }
}
