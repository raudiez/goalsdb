<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCMatchesGoals extends Model{

	protected $table = 'lofc_matches_goals';

	public static function getByID($id){
		return DB::table('lofc_matches_goals')->where('id', $id)->first();
	}

	public static function getByJunctionAndLegAndTeam($id_junction, $leg, $id_team){
		return DB::select('SELECT lofc_matches_goals.id, lofc_players.name AS player_name, lofc_matches_goals.count FROM lofc_matches_goals INNER JOIN lofc_players ON (lofc_players.id = lofc_matches_goals.id_player) WHERE (lofc_matches_goals.leg = '.$leg.' AND lofc_matches_goals.id_junction = '.$id_junction.' AND lofc_matches_goals.id_team = '.$id_team.')');
	}

	public static function insertNew($id_player, $id_team, $id_junction, $leg, $count){
		DB::table('lofc_matches_goals')->
			insert(['id_player' => $id_player, 'id_team' => $id_team, 'id_junction' => $id_junction, 'leg' => $leg, 'count' => $count]);
	}

}
