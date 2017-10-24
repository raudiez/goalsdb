<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCJunction;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class JunctionsController extends Controller{

  public function save(Request $request, $junction_id, $leg){
    $notes = $request->input('notes');
    $junction = LOFCJunction::getByID($junction_id);
    $ended = $junction->ended;
    $played_1 = $junction->played_1;
    $played_2 = $junction->played_2;
    $db_notes = $junction->notes;

    if ($junction->second_leg && $leg == 1){
      if ($notes != '') {
        if(preg_match('/Ida: (.+)\n/', $db_notes, $matches)){
          $notes = preg_replace('/Ida: (.+)\n/', "Ida: ".$notes."\n", $db_notes, 1);
        }else{
          $notes = $db_notes."Ida: ".$notes."\n";
        }
      }
      $played_1 = 1;
    }elseif ($junction->second_leg && $leg == 2){
      if ($notes != '') {
        if(preg_match('/Vuelta: (.+)\n/', $db_notes, $matches)){
          $notes = preg_replace('/Vuelta: (.+)\n/', "Vuelta: ".$notes."\n", $db_notes, 1);
        }else{
          $notes = $db_notes."Vuelta: ".$notes."\n";
        }
      }
      $played_2 = 1;
      $ended = 1;
    }else{ //1leg, finished.
      $played_1 = 1;
      $ended = 1;
    }

    //Calculates winner:
    $id_winner = NULL;
    if ($junction->second_leg){ //Away goals value x2.
      $g_L = $junction->goals_L_1 + $junction->goals_L_2;
      $g_V = $junction->goals_V_1 + $junction->goals_V_2;

      if ($g_L < $g_V) $id_winner = $junction->id_V_team;
      elseif ($g_L > $g_V) $id_winner = $junction->id_L_team;
      else{//Draw, check away goals.
        if ($junction->goals_L_2 < $junction->goals_V_1) $id_winner = $junction->id_V_team;
        elseif ($junction->goals_L_2 > $junction->goals_V_1) $id_winner = $junction->id_L_team;
      }
    }else{//1leg:
      if ($junction->goals_L_1 < $junction->goals_V_1) $id_winner = $junction->id_V_team;
      else $id_winner = $junction->id_L_team;
    }

    LOFCJunction::updateJunctionMatch($junction_id, $played_1, $played_2, $ended, $notes, $id_winner);
    $this->checkAndCalculateNext($junction->id_competition, $junction->phase);
    return redirect('lofc/show_competition/'.$junction->id_competition);
  }

  private function checkAndCalculateNext($id_competition, $phase){
    $junctions = LOFCJunction::getByCompetitionIDandPhase($id_competition, $phase);
    $all_ended = 1;
    //checks if all junctions of phase has ended
    foreach ($junctions as $junction){
      $all_ended = $all_ended and $junction->ended;
    }
    if ($all_ended){
      //if ended, calculate next phase junction's teams
      $phaseTo = $phase +1;
      $nextJunctions = LOFCJunction::getByCompetitionIDandPhase($id_competition, $phaseTo);
      if (!empty($nextJunctions)){
        foreach ($nextJunctions as $nextJunction){
          //inicialize vars
          $junction_L_team = $nextJunction->id_L_team;
          $junction_V_team = $nextJunction->id_V_team;
          //teams names of junction
          $junctionWithTeams = LOFCJunction::joinJunction_Teams($nextJunction->id)['0'];
          //check if undefined teams for junction (local)
          if(substr($junctionWithTeams->lofc_team_L_name, 0, 1) === 'G'){
              //search for the team that classifies
              $short = substr($junctionWithTeams->lofc_team_L_name, 1);
              $junction_L_team = LOFCJunction::getByCompetitionIDandShortName($id_competition, $short)->id_winner;
          }
          //(visitor)
          if(substr($junctionWithTeams->lofc_team_V_name, 0, 1) === 'G'){
              $short = substr($junctionWithTeams->lofc_team_V_name, 1);
              $junction_V_team = LOFCJunction::getByCompetitionIDandShortName($id_competition, $short)->id_winner;
          }
          LOFCJunction::updateNextJunction($nextJunction->id, $junction_L_team, $junction_V_team);
        }
      }
    }
  }
        
}