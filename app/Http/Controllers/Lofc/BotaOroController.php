<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCSeason;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use RuntimeException;

class BotaOroController extends Controller{

  public function show($season_id){
    $season = LOFCSeason::getByID($season_id);
    $client = new Client(['http_errors' => false, 'connect_timeout' => 8, 'timeout' => 10]);
    try {
      $response = $client->get("http://www.gesliga.es/Estadisticas.aspx?Liga=$season->id_gesliga");
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

        $goles_liga = array();
        for($i = 0; $i < count($arr_players); $i++){
          array_push($goles_liga, array('name' => $arr_players[$i], 'goals' => $arr_goals[$i]));
        }
      }else $goles_liga = array();
    }else $goles_liga = array();

    $season_goals = LOFCSeason::joinGoals_Season($season_id);

    $competitions_goals = array();
    foreach ($season_goals as $value) {
      $competition = $value->competition_name;
      if(!isset($competitions_goals[$competition])) {
        $competitions_goals[$competition] = array();
        array_push($competitions_goals[$competition], array('player_name' => $value->player_name, 'goals' => $value->count,  ));
      }else array_push($competitions_goals[$competition], array('player_name' => $value->player_name, 'goals' => $value->count,  ));
    }

    $goles_totales = $goles_liga; //Inicializa totales con los de liga 
    foreach ($competitions_goals as $competition_goals) {
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
          array_push($goles_totales, array('name' => $value['player_name'], 'goals' => $value['goals']));
        }
      }
    }

    if (empty($competitions_goals)){
      $goles_totales = $goles_liga;
    }

    //sort personalizado
    usort($goles_totales, function($a, $b) {
              return $a['goals'] < $b['goals'];
          });

    //solo top10 tras todo
    $goles_liga = array_slice($goles_liga, 0, 10, true);
    $goles_totales = array_slice($goles_totales, 0, 10, true);

  	return view('lofc/botaoro', compact('season_id', 'goles_liga', 'goles_totales', 'competitions_goals'));
  }
        
}