<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
	public static function getRecordsByOwnerAndVersion($owner_id, $version){
		return DB::table('records')->
			join('players','records.player_id','=','players.id')->
			select('records.goals', 'players.name AS player_name')->
			where('players.owner_id',$owner_id)->
			where('records.version', $version)->
			orderBy('goals','asc')->
			get();
	}

	public static function getMaxByOwnerAndVersion($owner_id, $version){
		return DB::table('records')->
			join('players','records.player_id','=','players.id')->
			select('records.goals', 'players.name AS player_name')->
			where('players.owner_id',$owner_id)->
			where('records.version', $version)->
			max('records.goals');
	}

	public static function insert($player_id, $goals, $version){
		$now = date('Y-m-d G:i:s');
		DB::table('records')->insert(
			['player_id' => $player_id, 'goals' => $goals, 'version' => $version, 'created_at' => $now, 'updated_at' => $now ]
		);
	}

}
