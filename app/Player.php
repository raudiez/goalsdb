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
			orderBy('name','asc')->
			get();
	}

	public static function joinPlayersGoals_Club(){
		return DB::table('players')->
			join('teams','players.team_id','=','teams.id')->
			select('players.name', 'teams.name AS team_name','players.goals_club')->
			orderBy('goals_club','desc')->
			orderBy('name','asc')->
			get();
	}

	/*
	SELECT teams.name, SUM(coalesce(players.goals_club ,0)+COALESCE(players.goals_career,0)) as goles_totales from players INNER JOIN teams ON players.team_id = teams.id GROUP by teams.id
	*/

	public static function joinClubTotalGoals(){
		return DB::select('SELECT teams.name as team_name, SUM(coalesce(players.goals_club ,0)+COALESCE(players.goals_career,0)) as total_goals from players INNER JOIN teams ON players.team_id = teams.id GROUP by teams.id order by total_goals desc');
	}

	public static function getAllPlayersGoals(){
		$all_goals_club = DB::table('players')->
			sum('goals_club');
		$all_goals_career = DB::table('players')->
			sum('goals_career');
		return $all_goals_club + $all_goals_career;
	}

	public static function updateByID($id, $name, $goals_club, $goals_career){
		DB::table('players')->
			where('id',$id)->
			update(['name' => $name, 'goals_club' => $goals_club, 'goals_career' => $goals_career, 'updated_at' => date('Y-m-d G:i:s') ]);
	}

	public static function insertNew($player_name, $team_id){
		$now = date('Y-m-d G:i:s');
		DB::table('players')->
			insert(['team_id' => $team_id, 'name' => $player_name, 'goals_club' => 0, 'goals_career' => 0, 'created_at' => $now, 'updated_at' => $now ]);
	}
}