<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\Record;

use Illuminate\Http\Request;

use App\Http\Requests;

class RecordsController extends Controller
{
  public function form($team_id){
  	$teams = Team::all();
    $max_record = Record::getMaxByTeam_id($team_id);
    $new_record = (($max_record/100)+1)*100;
  	$team = Team::getByID($team_id);
  	$players = Player::getByTeamID_orderBy($team_id,'name','asc');

  	return view('records/form', compact('teams','team','players', 'new_record'));
  }

  public function save(Request $request,$team_id){

  	$player_id = $request->input('player_id');
  	$goals = $request->input('goals');

  	Record::insert($player_id,$goals);

  	return redirect('teams/show/'.$team_id);
  }
}
