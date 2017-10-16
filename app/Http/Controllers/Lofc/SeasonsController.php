<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCSeason;
use App\LOFCTeam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class SeasonsController extends Controller{

  public function create(){
    return view('lofc/seasons/create');
  }

  public function save(Request $request){
  	$teams_n = $request->input('teams_n');
  	$season = new LOFCSeason;
  	$season->save();
  	$season_id = $season->id;
  	for ($i=0; $i < $teams_n; $i++) { 
  		$team = new LOFCTeam;
  		$team->id_season = $season_id;
  		$team->name = "Participante ".($i+1);
  		$team->save();
  	}
    return redirect('lofc/teams/modify/'.$season_id);
  }
  
}