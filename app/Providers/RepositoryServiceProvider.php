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
                \App\Repositories\RoleRepository::class,
                \App\Repositories\Eloquent\RoleRepositoryEloquent::class
            );
        }
    }
