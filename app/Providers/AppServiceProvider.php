<?php

namespace App\Providers;

use App\LOFCSeason;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //global variable to all views
        $lofc_seasons = LOFCSeason::all();
        view()->share('lofc_seasons', $lofc_seasons);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
