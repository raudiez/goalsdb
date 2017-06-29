<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCPlayer extends Model{

	protected $table = 'lofc_players';

	public static function getByID($id){
		return DB::table('lofc_players')->where('id', $id)->first();
	}

	public static function getByTeamID($id_team){
		return DB::table('lofc_players')->where('id_team', $id_team)->get();
	}

	public static function insertNew($player_name, $team_id){
		DB::table('lofc_players')->
			insert(['id_team' => $team_id, 'name' => $player_name]);
	}
}
