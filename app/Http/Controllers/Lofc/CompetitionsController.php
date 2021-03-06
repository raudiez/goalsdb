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
    $season_calendar = LOFCSeason::getByID($season_id)->calendar;
    $season_name = LOFCSeason::getByID($season_id)->name;
    $competitions = LOFCCompetition::getBySeasonID($season_id);
    $params = array(
        'q'             => 'LOFC GALA TEMPORADA '.$season_id,
        'type'          => 'video',
        'part'          => 'id, snippet',
        'maxResults'    => 50
    );
    $videos = Youtube::searchAdvanced($params);
    $gala = array();
    if (!empty($videos)) {
      foreach ($videos as $video) {
        if (strpos($video->snippet->title, 'TEMPORADA '.$season_id)) {
          $gala = array(
            'videoId' => $video->id->videoId, 
            'title' => $video->snippet->title,
          );
        }
      }
    }
    
    return view('lofc/competitions/list', compact('season_id', 'season_calendar', 'season_name', 'competitions', 'gala'));
  }

  public function show_competition($season_id, $competition_id){
    $season_name = LOFCSeason::getByID($season_id)->name;
    $competition = LOFCCompetition::getByID($competition_id);
    $junctions = LOFCJunction::joinCompetition_Teams($competition_id);
    $params = array(
        'q'             => $competition->name.' TEMPORADA '.$competition->id_season,
        'type'          => 'video',
        'part'          => 'id, snippet',
        'maxResults'    => 50
    );
    $videos = Youtube::searchAdvanced($params);
    return view('lofc/competitions/show', compact('season_id', 'season_name', 'competition', 'junctions', 'videos'));
  }

  public function league_videos($season_id, $league_name){
    $season_name = LOFCSeason::getByID($season_id)->name;
    $params = array(
        'q'             => $league_name.' TEMPORADA '.$season_id,
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
          if (strpos($league_name, "Grupo")) {
            preg_match('/.* Grupo ([AB])/', $league_name, $matches);
            if (preg_match('/TEMPORADA '.$season_id.' JORNADA '.$jornada.' GRUPO '.$matches[1].'[.\s].*/', $result->snippet->description)) {
              $jornadas[$jornada][$i] = array(
                'videoId' => $result->id->videoId, 
                'title' => $result->snippet->title,
                );
              $i++;
            }
          }
          elseif (strpos($league_name, "División")) {
            preg_match('/.* División ([12])/', $league_name, $matches);
            if (preg_match('/TEMPORADA '.$season_id.' JORNADA '.$jornada.' DIVISION '.$matches[1].'[.\s].*/', $result->snippet->description)) {
              $jornadas[$jornada][$i] = array(
                'videoId' => $result->id->videoId, 
                'title' => $result->snippet->title,
                );
              $i++;
            }
          }else{
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
    }
    return view('lofc/leagues/videos', compact('season_id', 'season_name', 'league_name', 'jornadas'));
  }

  public function form_cup($season_id){
    $season_name = LOFCSeason::getByID($season_id)->name;
    return view('lofc/competitions/form_cup', compact('season_id', 'season_name'));
  }

  public function save_cup(Request $request, $season_id){
    $name = $request->input('name');
    $num_teams = $request->input('num_teams');
    $round_trip = null !== $request->input('round_trip');
    LOFCCompetition::insert($season_id, $name, $num_teams, $round_trip);
    return redirect('lofc/competitions/'.$season_id);
  }

  public function form_league($season_id){
    $season_name = LOFCSeason::getByID($season_id)->name;
    return view('lofc/competitions/form_league', compact('season_id', 'season_name'));
  }

  public function save_league(Request $request, $season_id){
    $name = $request->input('name');
    $id_gesliga = $request->input('id_gesliga');
    LOFCCompetition::insert($season_id, $name, NULL, 0, 1, $id_gesliga);
    return redirect('lofc/competitions/'.$season_id);
  }
        
}