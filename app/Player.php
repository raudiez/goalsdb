<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
  public function user()
  {
  	return $this->belongsTo(User::class);
  }

  public static function getByOwnerAndVersion_orderBy($owner_id,$version,$order,$order_dir){
		return DB::table('players')->
			select('id', 'name', 'goals_club_'.$version.' AS goals_club', 'goals_career_'.$version.' AS goals_career')->
			where('owner_id', $owner_id)->
			orderBy($order,$order_dir)->
			orderBy('name','asc')->
			get();
	}

	public static function joinPlayersGoals_Club($version){
		return DB::table('players')->
			join('teams','players.owner_id','=','teams.owner_id')->
			select('players.name', 'teams.name AS team_name','players.goals_club_'.$version)->
			where('teams.version', $version)->
			orderBy('goals_club_'.$version,'desc')->
			orderBy('name','asc')->
			get();
	}

	/*
	SELECT teams.name, SUM(coalesce(players.goals_club,0)+COALESCE(players.goals_career,0)) as goles_totales from players INNER JOIN teams ON players.owner_id = teams.id GROUP by teams.id
	*/

	public static function joinClubTotalGoals($version){
		return DB::select('SELECT teams.name as team_name, SUM(coalesce(players.goals_club_'.$version.' ,0)+COALESCE(players.goals_career_'.$version.',0)) as total_goals from players INNER JOIN teams ON players.owner_id = teams.owner_id and teams.version = '.$version.' GROUP by teams.id order by total_goals desc');
	}

	public static function getAllPlayersGoals(){
		$all_goals_club_16 = DB::table('players')->
			sum('goals_club_16');
		$all_goals_career_16 = DB::table('players')->
			sum('goals_career_16');
		$all_goals_club_17 = DB::table('players')->
			sum('goals_club_17');
		$all_goals_career_17 = DB::table('players')->
			sum('goals_career_17');
		return $all_goals_club_16 + $all_goals_career_16 + $all_goals_club_17 + $all_goals_career_17;
	}

	public static function updateByID($id, $name, $version, $goals_club, $goals_career){
		DB::table('players')->
			where('id',$id)->
			update(['name' => $name, 'goals_club_'.$version => $goals_club, 'goals_career_'.$version => $goals_career, 'updated_at' => date('Y-m-d G:i:s') ]);
	}

	public static function insertNew($player_name, $owner_id){
		$now = date('Y-m-d G:i:s');
		DB::table('players')->
			insert(['owner_id' => $owner_id, 'name' => $player_name, 'goals_club_16' => 0, 'goals_career_16' => 0, 'goals_club_17' => 0, 'goals_career_17' => 0,  'created_at' => $now, 'updated_at' => $now ]);
	}
}