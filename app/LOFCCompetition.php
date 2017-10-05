<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCCompetition extends Model{

	protected $table = 'lofc_competitions';

	public static function getByID($id){
		return DB::table('lofc_competitions')->where('id', $id)->first();
	}

	public static function getBySeasonID($id_season){
		return DB::table('lofc_competitions')->where('id_season', $id_season)->orderBy('name','asc')->get();
	}

	public static function getLeaguesBySeasonID($id_season){
		return DB::table('lofc_competitions')->where([
			['id_season', $id_season],
			['is_league', '1'],
			])->orderBy('name','asc')->get();
	}

	public static function insert($id_season, $name, $num_teams, $round_trip, $is_league = 0, $id_gesliga = NULL){
		DB::table('lofc_competitions')->insert([
    		'id_season' => $id_season,
    		'name' => $name,
    		'num_teams' => $num_teams,
    		'round_trip' => $round_trip,
    		'is_league' => $is_league,
    		'id_gesliga' => $id_gesliga

    	]);
	}

}
