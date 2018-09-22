<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCTeam;
use App\LOFCSeason;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class TeamsController extends Controller{

  public function modify($season_id){
    $season_name = LOFCSeason::getByID($season_id)->name;
  	$lofc_teams = LOFCTeam::getBySeasonID($season_id);
  	$lofc_teams_logos = LOFCTeam::getAllLogos();
    return view('lofc/teams/modify', compact('season_id', 'season_name', 'lofc_teams', 'lofc_teams_logos'));
  }

  public function save(Request $request, $team_id){
  	$name = $request->input('team_name');
  	$logo_img = $request->input('logo_img');
  	$season_id = $request->input('season_id');
  	LOFCTeam::updateTeam($team_id, $name, $logo_img);
  	return redirect('lofc/teams/modify/'.$season_id);
  }

  public function add_logo(){
  	# code...
  }
  
}