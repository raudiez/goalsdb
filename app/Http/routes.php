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
Route::get('teams/show/{id}/{order_by?}/{order_by_dir?}', 'TeamsController@show');
Route::post('teams/save/{id}', 'TeamsController@save');

//Record
Route::get('records/form/{id}', 'RecordsController@form');
Route::post('records/save/{id}', 'RecordsController@save');

