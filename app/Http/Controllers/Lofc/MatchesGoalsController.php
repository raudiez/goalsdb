<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCCompetition;
use App\LOFCJunction;
use App\LOFCPlayer;
use App\LOFCMatchesGoals;
use App\LOFCGoals;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class MatchesGoalsController extends Controller{

  public function match_form($junction_id, $leg){
    $junction = LOFCJunction::joinJunction_Teams($junction_id)['0'];
    $players_L = LOFCPlayer::getByTeamID($junction->id_L_team);
    $players_V = LOFCPlayer::getByTeamID($junction->id_V_team);
    $competition = LOFCCompetition::getByID($junction->id_competition);
    $match_goals_L = LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction_id, $leg, $junction->id_L_team);
    $match_goals_V = LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction_id, $leg, $junction->id_V_team);

    $notes = '';
    if ($junction->second_leg && $leg == 1){
      if(preg_match("/Ida: (.+)\n/", $junction->notes, $matches))
        $notes = $matches[1];
    }elseif ($junction->second_leg && $leg == 2){
      if(preg_match("/Vuelta: (.+)\n/", $junction->notes, $matches))
        $notes = $matches[1];
    }else{ //Partido único.
      $notes = $junction->notes;
    }
    return view('lofc/competitions/matches/form', compact('competition', 'junction', 'leg', 'players_L', 'players_V', 'match_goals_L', 'match_goals_V', 'notes'));
  }

  public function match_save(Request $request, $junction_id, $leg){
    $this->validate($request, [
        'count' => 'required|min:1',
        'player_id' => 'bail|required:not_in:0',
    ]);
    $count = $request->input('count');
    $player_id = $request->input('player_id');
    $player = LOFCPlayer::getByID($player_id);
    $junction = LOFCJunction::getByID($junction_id);
    LOFCMatchesGoals::insertNew($player_id, $player->id_team, $junction_id, $leg, $count);
    LOFCGoals::insertOrUpdate($player_id, $junction->id_competition, $count);
    if ($player->id_team == $junction->id_L_team){
      LOFCJunction::updateGoals($junction_id, 'L', $leg, $count);
    }else LOFCJunction::updateGoals($junction_id, 'V', $leg, $count);
    return redirect('lofc/match_form/'.$junction_id.'/'.$leg);
  }

  public function delete_match_goal($id_match_goal){
    $match_goal = LOFCMatchesGoals::getByID($id_match_goal);
    $count = $match_goal->count;
    $leg = $match_goal->leg;
    $player_id = $match_goal->id_player;
    $player = LOFCPlayer::getByID($player_id);
    $junction_id = $match_goal->id_junction;
    $junction = LOFCJunction::getByID($junction_id);
    LOFCMatchesGoals::destroy($id_match_goal);
    LOFCGoals::insertOrUpdate($player_id, $junction->id_competition, -$count);
    if ($player->id_team == $junction->id_L_team){
      LOFCJunction::updateGoals($junction_id, 'L', $leg, -$count);
    }else LOFCJunction::updateGoals($junction_id, 'V', $leg, -$count);
    return redirect('lofc/match_form/'.$junction_id.'/'.$leg);
  }
        
}