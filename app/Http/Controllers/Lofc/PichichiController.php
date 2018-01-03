<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCCompetition;
use App\LOFCSeason;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use RuntimeException;

class PichichiController extends Controller{

  public function show($season_id){
    $leagues = LOFCCompetition::getLeaguesBySeasonID($season_id);
    $leagues_goals = array();
    $error_gesliga = FALSE;
    foreach ($leagues as $league) {
      $leagues_goals[$league->name] = array();
      if (!$error_gesliga) {
        $client = new Client(['http_errors' => false, 'connect_timeout' => 8, 'timeout' => 10]);
        try {
          $response = $client->get("http://www.gesliga.es/Estadisticas.aspx?Liga=$league->id_gesliga");
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
          if ($crawler->filter('#ctl00_CH1_rptEstadisticas_ctl00_grd')->count()){
            $goleadores_table = $crawler->filter('#ctl00_CH1_rptEstadisticas_ctl00_grd')->html();

            $players = trim(preg_replace("/<(?:td|th)[^>]*>.*?<\/(?:td|th)>\s+<\/tr>/i", "</tr>", $goleadores_table));
            $players = trim(preg_replace("/<(?:td|th)[^>]*>.*?<\/(?:td|th)>\s+<\/tr>/i", "</tr>", $players));
            $players = trim(preg_replace('/(<tr.+|.+tr>|<th.+)/', '', $players));
            $players = trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $players));
            $players = trim(preg_replace('/(<td>|<\/td>)/', '', $players));
            $players = trim(preg_replace('/\s+\n/', "\n", $players));

            $goals = trim(preg_replace( '/[^0-9\n]/', '', $goleadores_table ));
            $goals = trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $goals));

            $arr_players = explode("\n", $players);
            $arr_goals = explode("\n", $goals);

            for($i = 0; $i < count($arr_players); $i++){
              array_push($leagues_goals[$league->name], array('name' => $arr_players[$i], 'goals' => $arr_goals[$i]));
            }
          }else $error_gesliga = TRUE;
        }else $error_gesliga = RUE;
      }
    }
    if($error_gesliga) $leagues_goals = array();

    $season_goals = LOFCSeason::joinGoals_Season($season_id);

    $competitions_goals = array();
    foreach ($season_goals as $value) {
      $competition = $value->competition_name;
      if(!isset($competitions_goals[$competition])) {
        $competitions_goals[$competition] = array();
        array_push($competitions_goals[$competition], array('player_name' => $value->player_name, 'goals' => $value->count,  ));
      }else array_push($competitions_goals[$competition], array('player_name' => $value->player_name, 'goals' => $value->count));
    }

    $goles_totales = array();

    //Primero añado los goles de Gesliga, por grupos.
    foreach ($leagues_goals as $league_name => $league_goals) {
      if(strpos($league_name, 'Grupo') !== false){
        preg_match('/.* Grupo ([AB])/', $league_name, $matches);
        $group_name = $matches[1];
        foreach ($league_goals as $value) {
          array_push($goles_totales, array('name' => $value['name'], 'goals' => $value['goals'], 'group_name' => $group_name));
        }
      }else{
        foreach ($league_goals as $value) {
          array_push($goles_totales, array('name' => $value['name'], 'goals' => $value['goals']));
        }
      }
    }

    //Luego añado los goles de Playoff
    foreach ($competitions_goals as $competition_name => $competition_goals) {
      //Solo añado goles de la BD de Playoff
      if (strpos($competition_name, 'Playoff') !== false){
        foreach ($competition_goals as $value) {
          $k = FALSE;
          foreach ($goles_totales as $key => $cpy) {
            if ($cpy['name'] == $value['player_name']){
              $k = $key;
            }
          }
          if (isset($k) && $k !== FALSE){
            $goles_totales[$k]['goals'] += $value['goals'];
          }else {
            //Al no saber el grupo, no pongo grupo.
            array_push($goles_totales, array('name' => $value['player_name'], 'goals' => $value['goals'], 'group_name' => NULL));
          }
        }
      }
    }

    //sort personalizado
    usort($goles_totales, function($a, $b) {
              return $a['goals'] < $b['goals'];
          });

    //solo top10 tras todo
    $goles_totales = array_slice($goles_totales, 0, 10, true);

  	return view('lofc/pichichi', compact('season_id', 'leagues_goals', 'goles_totales'));
  }
        
}