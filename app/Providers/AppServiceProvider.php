<?php

namespace App\Providers;

use App\User;
use App\Team;
use App\LOFCSeason;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        //MEJORAR ESTO:
        $owners = User::all()->sortBy('name');
        $teams = Team::all()->sortBy('name');
        view()->share('owners', $owners);
        view()->share('teams', $teams);
        //CARGAR SOLO SI SE ESTÁ LOGUEADO
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
