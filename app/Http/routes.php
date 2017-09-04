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

//Home
Route::get('/', 'HomeController@index');

//Auth
Route::auth();
Route::get('/register', 'Auth\AuthController@getRegister');
Route::get('/login', 'Auth\AuthController@getLogin');

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


//LOFC:

////Competitions
Route::get('lofc/competitions/{season_id}', 'Lofc\CompetitionsController@list_competitions');
Route::get('lofc/show_competition/{competition_id}', 'Lofc\CompetitionsController@show_competition');
Route::get('lofc/league_videos/{season_id}/{league_name}', 'Lofc\CompetitionsController@league_videos');

////MatchesGoals
Route::get('lofc/match_form/{junction_id}/{leg}', 
	['middleware' => 'auth',
	 'uses' => 'Lofc\MatchesGoalsController@match_form'
	]);
Route::post('lofc/match_save/{junction_id}/{leg}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\MatchesGoalsController@match_save'
	]);
Route::get('lofc/delete_match_goal/{id_match_goal}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\MatchesGoalsController@delete_match_goal'
	]);

////Players
Route::get('lofc/players_form/{team_id}/{junction_id}/{leg}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\PlayersController@players_form'
	]);
Route::post('lofc/players_save/{team_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\PlayersController@players_save'
	]);

////Junctions
Route::post('lofc/junction_save/{junction_id}/{leg}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\JunctionsController@junction_save'
	]);

////BotaOro
Route::get('lofc/botaoro/{season_id}', 'Lofc\BotaOroController@show');

