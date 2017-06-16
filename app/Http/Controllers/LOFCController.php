<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\LOFCCompetition;
use App\LOFCSeason;
use App\LOFCJunction;

use Illuminate\Http\Request;

use App\Http\Requests;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use RuntimeException;

use Alaouy\Youtube\Facades\Youtube;

class LOFCController extends Controller{

  public function botaoro($season_id){
    $season = LOFCSeason::getByID($season_id);

    $client = new Client();
    $response = $client->get("http://www.gesliga.es/Estadisticas.aspx?Liga=$season->id_gesliga");
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

    $season_goals = LOFCSeason::joinGoals_Season($season_id);

    $competitions_goals = array();
    foreach ($season_goals as $value) {
      $competition = $value->competition_name;
      if(!isset($competitions_goals[$competition])) {
        $competitions_goals[$competition] = array();
        array_push($competitions_goals[$competition], array('player_name' => $value->player_name, 'goals' => $value->count,  ));
      }else array_push($competitions_goals[$competition], array('player_name' => $value->player_name, 'goals' => $value->count,  ));
    }

    $merged = FALSE; //var_control si se han añadido los goles de liga
    $goles_totales = array(); //Inicializa totales
    $goles_liga_cpy = $goles_liga; //copia, para luego meter solo 
    foreach ($competitions_goals as $competition_goals) {
      foreach ($competition_goals as $value) {
        if (!$merged) {
          $name = array_column($goles_liga_cpy, 'name'); //buscamos solo nombres
          $k = array_search($value['player_name'], $name); //busca en goles_liga
          if ($k){
            array_push($goles_totales, array('name' => $value['player_name'], 'goals' => $value['goals']+$goles_liga_cpy[$k]['goals']));
            unset($goles_liga_cpy[$k]);
          }else {
            array_push($goles_totales, array('name' => $value['player_name'], 'goals' => $value['goals']));
          }
        }else{
          $name = array_column($goles_totales, 'name');
          $k = array_search($value['player_name'], $name);
          if ($k){
            $goles_totales[$k]['goals'] += $value['goals'];
          }else{
            array_push($goles_totales, array('name' => $value['player_name'], 'goals' => $value['goals']));
          }
        }
        
      }
      if(!$merged){
        $goles_totales = array_merge($goles_totales, $goles_liga_cpy);
        $merged = TRUE;
      }
    }

    if (empty($competitions_goals)){
      $goles_totales = array_merge($goles_totales, $goles_liga);
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

  public function competitions($season_id){
    $season = LOFCSeason::getByID($season_id);

    $client = new Client();
    $response = $client->get("http://www.gesliga.es/Clasificacion.aspx?Liga=$season->id_gesliga");
    $gesliga = $response->getBody()->getContents();
    $crawler = new Crawler($gesliga);
    $gesliga_name = $crawler->filter('#ctl00_menuLigaDesktop_lblNombreLiga')->text();

    $competitions = LOFCCompetition::getBySeasonID($season_id);
    return view('lofc/competitions/list', compact('season', 'gesliga_name', 'competitions'));
  }

  public function show_competition($competition_id){
    $competition = LOFCCompetition::getByID($competition_id);
    $junctions = LOFCJunction::joinCompetition_Teams($competition_id);
    return view('lofc/competitions/show', compact('competition', 'junctions'));
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