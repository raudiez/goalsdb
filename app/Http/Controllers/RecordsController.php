<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\Record;
use App\User;
use App\LOFCSeason;

use Illuminate\Http\Request;

use App\Http\Requests;

class RecordsController extends Controller{

  public function __construct()
    {
        $this->middleware('auth');
    }

  public function form($team_id){
    $owners = User::all()->sortBy('name');
  	$teams = Team::all()->sortBy('name');
    $lofc_seasons = LOFCSeason::all();
    $team = Team::getByID($team_id);
    $max_record = Record::getMaxByOwnerAndVersion($team->owner_id,$team->version);
    $new_record = (($max_record/100)+1)*100;
  	$players = Player::getByOwnerAndVersion_orderBy($team->owner_id,$team->version,'name','asc');

  	return view('records/form', compact('owners', 'teams', 'lofc_seasons', 'team','players', 'new_record'));
  }

  public function save(Request $request,$team_id){

  	$player_id = $request->input('player_id');
  	$goals = $request->input('goals');
    $version = $request->input('fifa_version');

  	Record::insert($player_id,$goals,$version);

  	return redirect('teams/show/'.$team_id);
  }
}
