<?php

namespace App\Http\Controllers\Lofc;

use App\LOFCCompetition;

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

    $goles_totales = array();
    //Inicializa totales con los de ligas de la temporada
    foreach ($leagues_goals as $league_goals) {
      foreach ($league_goals as $value) {
        array_push($goles_totales, array('name' => $value['name'], 'goals' => $value['goals']));
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