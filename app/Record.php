<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
	public static function joinRecords_byTeamID($team_id){
		return DB::table('records')->
			join('players','records.player_id','=','players.id')->
			select('records.goals', 'players.name AS player_name')->
			where('players.team_id',$team_id)->
			orderBy('goals','asc')->
			get();
	}

	public static function getMaxByTeam_id($team_id){
		return DB::table('records')->
			join('players','records.player_id','=','players.id')->
			select('records.goals', 'players.name AS player_name')->
			where('players.team_id',$team_id)->
			max('records.goals');
	}

	public static function insert($player_id, $goals){
		$now = date('Y-m-d G:i:s');
		DB::table('records')->insert(
			['player_id' => $player_id, 'goals' => $goals, 'created_at' => $now, 'updated_at' => $now ]
		);
	}

}
