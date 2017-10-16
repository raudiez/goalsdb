<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCCompetition;
use App\LOFCSeason;
use App\LOFCJunction;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use RuntimeException;

use Alaouy\Youtube\Facades\Youtube;

class CompetitionsController extends Controller{

  public function list_competitions($season_id){
    $competitions = LOFCCompetition::getBySeasonID($season_id);
    return view('lofc/competitions/list', compact('season_id', 'competitions'));
  }

  public function show_competition($competition_id){
    $competition = LOFCCompetition::getByID($competition_id);
    $junctions = LOFCJunction::joinCompetition_Teams($competition_id);
    $params = array(
        'q'             => $competition->name.' TEMPORADA '.$competition->id_season,
        'type'          => 'video',
        'part'          => 'id, snippet',
        'maxResults'    => 50
    );
    $videos = Youtube::searchAdvanced($params);
    return view('lofc/competitions/show', compact('competition', 'junctions', 'videos'));
  }

  public function league_videos($season_id, $league_name){
    $season = LOFCSeason::getByID($season_id);
    $params = array(
        'q'             => 'LOFC '.$league_name.' TEMPORADA'.$season_id,
        'type'          => 'video',
        'part'          => 'id, snippet',
        'maxResults'    => 50
    );
    $results = Youtube::searchAdvanced($params);
    $jornadas = array();
    if (!empty($results)) {
      for ($jornada=1; $jornada < 15; $jornada++) { 
        $i = 0;
        foreach ($results as $result) {
          if (preg_match('/TEMPORADA '.$season_id.' JORNADA '.$jornada.'[.\s].*/', $result->snippet->description)) {
            $jornadas[$jornada][$i] = array(
              'videoId' => $result->id->videoId, 
              'title' => $result->snippet->title,
              );
            $i++;
          }
        }
      }
    }
    return view('lofc/leagues/videos', compact('season', 'league_name', 'jornadas'));
  }

  public function form_cup($season_id){
    return view('lofc/competitions/form_cup', compact('season_id'));
  }

  public function save_cup(Request $request, $season_id){
    $name = $request->input('name');
    $num_teams = $request->input('num_teams');
    $round_trip = null !== $request->input('round_trip');
    LOFCCompetition::insert($season_id, $name, $num_teams, $round_trip);
    return redirect('lofc/competitions/'.$season_id);
  }

  public function form_league($season_id){
    return view('lofc/competitions/form_league', compact('season_id'));
  }

  public function save_league(Request $request, $season_id){
    $name = $request->input('name');
    $id_gesliga = $request->input('id_gesliga');
    LOFCCompetition::insert($season_id, $name, NULL, 0, 1, $id_gesliga);
    return redirect('lofc/competitions/'.$season_id);
  }
        
}