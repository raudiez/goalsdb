<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;

class PlayersController extends Controller{

	public function form($team_id){
    $owners = User::all()->sortBy('name');
  	$teams = Team::all()->sortBy('name');
  	$team = Team::getByID($team_id);

  	return view('players/form', compact('owners', 'teams','team'));
  }

  public function save(Request $request,$team_id){
  	$player_name = $request->input('player_name');
    $owner_id = $request->input('owner_id');
  	Player::insertNew($player_name,$owner_id);
  	return redirect('teams/show/'.$team_id);
  }
}
