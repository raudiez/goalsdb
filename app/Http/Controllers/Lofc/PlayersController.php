<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCTeam;
use App\LOFCPlayer;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class PlayersController extends Controller{

  public function players_form($season_id, $team_id, $junction_id, $leg){
    $team = LOFCTeam::getByID($team_id);
    return view('lofc/players/form', compact('season_id', 'team', 'junction_id', 'leg'));
  }

  public function players_save(Request $request, $season_id, $team_id){
    $player_name = $request->input('player_name');
    $junction_id = $request->input('junction_id');
    $leg = $request->input('leg');
    LOFCPlayer::insertNew($player_name,$team_id);
    return redirect('lofc/match_form/'.$season_id.'/'.$junction_id.'/'.$leg);
  }
        
}