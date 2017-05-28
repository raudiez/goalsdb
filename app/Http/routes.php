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

//User
Route::get('owners', 'UsersController@index');
Route::get('owners/show/{user_id}', 'UsersController@show');

//Team
Route::get('teams', 'TeamsController@index');
Route::get('teams/show/{team_id}/{order_by?}/{order_by_dir?}', 'TeamsController@show');
Route::post('teams/save/{team_id}', 'TeamsController@save');

//Player
Route::get('players/form/{team_id}', 'PlayersController@form');
Route::post('players/save/{team_id}', 'PlayersController@save');

//Record
Route::get('records/form/{team_id}', 'RecordsController@form');
Route::post('records/save/{team_id}', 'RecordsController@save');

//LOFC
Route::get('lofc/competitions', 'LOFCController@competitions');
Route::get('lofc/botaoro', 'LOFCController@botaoro');

