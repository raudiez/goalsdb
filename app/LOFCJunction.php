<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class LOFCJunction extends Model{

	protected $table = 'lofc_junctions';

	public static function getByID($id){
		return DB::table('lofc_junctions')->where('id', $id)->first();
	}

	public static function getByCompetitionID($id_competition){
		return DB::table('lofc_junctions')->where('id_competition', $id_competition)->orderBy('id')->get();
	}

	public static function joinJunction_Teams($id){
		return DB::select('SELECT lofc_junctions.id, lofc_junctions.id_competition, lofc_junctions.name, lofc_junctions.id_L_team, lofc_junctions.id_V_team, lofc_junctions.goals_L_1, lofc_junctions.goals_V_1, lofc_junctions.goals_L_2, lofc_junctions.goals_V_2, lofc_junctions.played_1, lofc_junctions.played_2, lofc_junctions.phase, lofc_junctions.second_leg, lofc_junctions.ended, lofc_junctions.notes, lofc_team_L.name AS lofc_team_L_name, lofc_team_L.logo_img AS lofc_team_L_logo_img, lofc_team_V.name AS lofc_team_V_name, lofc_team_V.logo_img AS lofc_team_V_logo_img FROM lofc_junctions INNER JOIN lofc_teams lofc_team_L ON (lofc_team_L.id = lofc_junctions.id_L_team) INNER JOIN lofc_teams lofc_team_V ON (lofc_team_V.id = lofc_junctions.id_V_team) WHERE lofc_junctions.id = '.$id);
	}

	public static function joinCompetition_Teams($competition_id){
		return DB::select('SELECT lofc_junctions.id, lofc_junctions.name, lofc_junctions.goals_L_1, lofc_junctions.goals_V_1, lofc_junctions.goals_L_2, lofc_junctions.goals_V_2, lofc_junctions.played_1, lofc_junctions.played_2, lofc_junctions.phase, lofc_junctions.second_leg, lofc_junctions.ended, lofc_junctions.notes, lofc_junctions.id_L_team, lofc_team_L.name AS lofc_team_L_name, lofc_team_L.logo_img AS lofc_team_L_logo_img, lofc_junctions.id_V_team, lofc_team_V.name AS lofc_team_V_name, lofc_team_V.logo_img AS lofc_team_V_logo_img FROM lofc_junctions INNER JOIN lofc_teams lofc_team_L ON (lofc_team_L.id = lofc_junctions.id_L_team) INNER JOIN lofc_teams lofc_team_V ON (lofc_team_V.id = lofc_junctions.id_V_team) WHERE id_competition = '.$competition_id);
	}

	public static function updateGoals($id, $team, $leg, $count){
		DB::table('lofc_junctions')->
			where('id',$id)->
			increment('goals_'.$team.'_'.$leg, $count);
	}

	public static function updateJunctionMatch($id, $played_1, $played_2, $ended, $notes){
		DB::table('lofc_junctions')->where('id', $id)->
			update([
				'played_1' => $played_1,
				'played_2' => $played_2,
				'ended' => $ended,
				'notes' => $notes,
				]);
	}

}
