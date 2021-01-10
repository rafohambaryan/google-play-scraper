<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (isset($_SERVER['REMOTE_ADDR']) AND !in_array($_SERVER['REMOTE_ADDR'], [
            '185.177.104.165',
            '217.76.15.67'
        ])) {
            abort(401);
        }
        //
    }
}
