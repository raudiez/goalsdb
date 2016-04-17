<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Team;

//Home
Route::get('/', 'HomeController@index');

//Auth
Route::auth();

//Team
Route::get('teams', 'TeamsController@index');
Route::get('teams/show/{id}', 'TeamsController@show');

