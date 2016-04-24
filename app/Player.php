<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function team()
    {
    	return $this->belongsTo(Team::class);
    }

    public static function getByTeamID_orderBy($team_id,$order,$order_dir){
			return DB::table('players')->
				where('team_id', $team_id)->
				orderBy($order,$order_dir)->
				get();
		}

		public static function joinPlayersGoals_Club(){
			return DB::table('players')->
				join('teams','players.team_id','=','teams.id')->
				select('players.name', 'teams.name AS team_name','players.goals_club')->
				orderBy('goals_club','desc')->
				get();
		}

		public static function updateByID($id, $name, $goals_club, $goals_career){
			DB::table('players')->
				where('id',$id)->
				update(['name' => $name, 'goals_club' => $goals_club, 'goals_career' => $goals_career, 'updated_at' => date('Y-m-d G:i:s') ]);
		}
}