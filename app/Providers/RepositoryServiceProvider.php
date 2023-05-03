<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;

    class RepositoryServiceProvider extends ServiceProvider
    {
        public function register()
        {
        }

        public function boot()
        {
            $this->app->bind(
                \App\Repositories\AccountRepository::class,
                \App\Repositories\Eloquent\AccountRepositoryEloquent::class
            );
            $this->app->bind(
                \App\Repositories\RoleRepository::class,
                \App\Repositories\Eloquent\RoleRepositoryEloquent::class
            );
            $this->app->bind(
                \App\Repositories\AddressRepository::class,
                \App\Repositories\Eloquent\AddressRepositoryEloquent::class
            );
            $this->app->bind(
                \App\Repositories\InformationRepository::class,
                \App\Repositories\Eloquent\InformationRepositoryEloquent::class
            );
        }
    }
