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

    public static function getByTeamID_orderBy($team_id,$order){
			return DB::table('players')->
				where('team_id', $team_id)->
				orderBy($order,'desc')->
				get();
		}

		public static function getAll_goalsClub(){
			return DB::table('players')->
				select('name', 'goals_club')->
				orderBy('goals_club','desc')->
				get();
		}
}
