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
    $season = LOFCSeason::getByID($season_id);

    $client = new Client(['http_errors' => false, 'connect_timeout' => 8, 'timeout' => 10]);
    try {
      $response = $client->get("http://www.gesliga.es/Clasificacion.aspx?Liga=$season->id_gesliga");
      //$response = $client->get("http://slowwly.robertomurray.co.uk/delay/600000/url/http://www.google.co.uk");
    }catch(Exception $e) {
      if ($e->hasResponse()) {
        $exception = (string) $e->getResponse()->getBody();
        \Log::info($exception);
      }
      $response = '';
    }catch (\GuzzleHttp\Exception\ConnectException $e) {
      if ($e->hasResponse()) {
        $exception = (string) $e->getResponse()->getBody();
        \Log::info($exception);
      }
      $response = '';
    }
    if (!is_string($response) && $response != ''){
      $gesliga = $response->getBody()->getContents();
      $crawler = new Crawler($gesliga);
      $gesliga_name = $crawler->filter('#ctl00_menuLigaDesktop_lblNombreLiga')->text();
    }else $gesliga_name = '';

    $competitions = LOFCCompetition::getBySeasonID($season_id);
    return view('lofc/competitions/list', compact('season', 'gesliga_name', 'competitions'));
  }

  public function show_competition($competition_id){
    $competition = LOFCCompetition::getByID($competition_id);
    $junctions = LOFCJunction::joinCompetition_Teams($competition_id);
    $params = array(
        'q'             => 'LOFC '.$competition->name.' TEMPORADA'.$competition->id_season,
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
    return view('lofc/leagues/videos', compact('season', 'league_name', 'jornadas'));
  }
        
}