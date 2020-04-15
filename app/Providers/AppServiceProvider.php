<?php

namespace App\Providers;

use App;
use Illuminate\Support\Facades\DB;
use URL;
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
        DB::listen(function ($query) {
            info($query->sql, [
                'bind' => $query->bindings,
                'time' => $query->time,
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (App::environment('production')) {
            URL::forceScheme('https');
        }
    }
}
