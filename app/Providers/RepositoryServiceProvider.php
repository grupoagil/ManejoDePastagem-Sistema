<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\FazendasRepository::class, \App\Repositories\FazendasRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FazendasPiquetesRepository::class, \App\Repositories\FazendasPiquetesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PastosRepository::class, \App\Repositories\PastosRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PastosPeriodoRepository::class, \App\Repositories\PastosPeriodoRepositoryEloquent::class);
        //:end-bindings:
    }
}
