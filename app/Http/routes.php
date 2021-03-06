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
Route::get('/disclaimer', 'HomeController@disclaimer');
Route::get('/contact', 'HomeController@contact_form');
Route::post('/contact_send', 'HomeController@contact_send');

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

////Seasons
Route::get('lofc/seasons/create',
	['middleware' => 'auth',
	 'uses' => 'Lofc\SeasonsController@create'
	]);
Route::post('lofc/seasons/save',
	['middleware' => 'auth',
	 'uses' => 'Lofc\SeasonsController@save'
	]);
Route::get('lofc/seasons/calendar_form/{season_id}',
	['middleware' => 'auth',
	'uses' => 'Lofc\SeasonsController@calendar_form'
	]);
Route::post('lofc/seasons/calendar_save/{season_id}',
	['middleware' => 'auth',
	'uses' => 'Lofc\SeasonsController@calendar_save'
	]);


////Competitions
Route::get('lofc/competitions/{season_id}', 'Lofc\CompetitionsController@list_competitions');
Route::get('lofc/show_competition/{season_id}/{competition_id}', 'Lofc\CompetitionsController@show_competition');
Route::get('lofc/league_videos/{season_id}/{league_name}', 'Lofc\CompetitionsController@league_videos');
Route::get('lofc/competitions/form_cup/{season_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\CompetitionsController@form_cup'
	]);
Route::post('lofc/competitions/save_cup/{season_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\CompetitionsController@save_cup'
	]);
Route::get('lofc/competitions/form_league/{season_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\CompetitionsController@form_league'
	]);
Route::post('lofc/competitions/save_league/{season_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\CompetitionsController@save_league'
	]);


////MatchesGoals
Route::get('lofc/match_form/{season_id}/{junction_id}/{leg}', 
	['middleware' => 'auth',
	 'uses' => 'Lofc\MatchesGoalsController@match_form'
	]);
Route::post('lofc/match_save/{season_id}/{junction_id}/{leg}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\MatchesGoalsController@match_save'
	]);
Route::get('lofc/delete_match_goal/{season_id}/{id_match_goal}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\MatchesGoalsController@delete_match_goal'
	]);

////Players
Route::get('lofc/players_form/{season_id}/{team_id}/{junction_id}/{leg}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\PlayersController@players_form'
	]);
Route::post('lofc/players_save/{season_id}/{team_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\PlayersController@players_save'
	]);


////Teams
Route::get('lofc/teams/modify/{season_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\TeamsController@modify'
	]);
Route::post('lofc/teams/save/{team_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\TeamsController@save'
	]);


////Junctions
Route::get('lofc/junctions/edit/{season_id}/{junction_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\JunctionsController@edit'
	]);
Route::post('lofc/junctions/update/{season_id}/{junction_id}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\JunctionsController@update'
	]);
Route::post('lofc/junction_save/{season_id}/{junction_id}/{leg}',
	['middleware' => 'auth',
	 'uses' => 'Lofc\JunctionsController@save'
	]);

////Pichichi
Route::get('lofc/pichichi/{season_id}', 'Lofc\PichichiController@show');

////BotaOro
Route::get('lofc/botaoro/{season_id}', 'Lofc\BotaOroController@show');


////Palmares
Route::get('lofc/palmares', 'Lofc\PalmaresController@show');
Route::get('lofc/palmares/form',
	['middleware' => 'auth',
	'uses' => 'Lofc\PalmaresController@form'
	]);
Route::post('lofc/palmares/save',
	['middleware' => 'auth',
	'uses' => 'Lofc\PalmaresController@save'
	]);

////Reglamento
Route::get('lofc/reglamento', 'Lofc\ReglamentoController@show');
Route::get('lofc/reglamento/form',
	['middleware' => 'auth',
	'uses' => 'Lofc\ReglamentoController@form'
	]);
Route::post('lofc/reglamento/save',
	['middleware' => 'auth',
	'uses' => 'Lofc\ReglamentoController@save'
	]);

////Estadisticas
Route::get('lofc/stats', 'Lofc\EstadisticasController@show');
Route::get('lofc/stats/form',
	['middleware' => 'auth',
	'uses' => 'Lofc\EstadisticasController@form'
	]);
Route::post('lofc/stats/save',
	['middleware' => 'auth',
	'uses' => 'Lofc\EstadisticasController@save'
	]);
