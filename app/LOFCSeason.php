<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCSeason extends Model{

	protected $table = 'lofc_seasons';
	
	public $timestamps = false;

	public static function getByID($id){
		return DB::table('lofc_seasons')->where('id', $id)->first();
	}

	public static function joinGoals_Season($season_id){
		return DB::select('SELECT lofc_goals.id, lofc_players.name AS player_name, lofc_competitions.name AS competition_name, lofc_goals.count FROM lofc_goals INNER JOIN lofc_players ON (lofc_players.id = lofc_goals.id_player) INNER JOIN lofc_competitions ON (lofc_competitions.id = lofc_goals.id_competition) WHERE lofc_competitions.id_season = '.$season_id);
	}

}
