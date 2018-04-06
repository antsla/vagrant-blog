<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*DB::listen(function ($query) {
            echo "<pre>";
            print_r([
                $query->sql,
                $query->bindings,
                $query->time
            ]);
            echo "</pre>";
        });*/
        /*if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }*/
    }
}
