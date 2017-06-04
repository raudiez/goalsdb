<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\LOFCCompetition;
use App\LOFCSeason;

use Illuminate\Http\Request;

use App\Http\Requests;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use RuntimeException;

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

    //PRUEBAS
    /*$goles_double = array(array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Batshuayi', 'goals' => 3), array('name' => 'Serresiete', 'goals' => 20));
    $goles_last = array(array('name' => 'Ibrahimovic', 'goals' => 1), array('name' => 'Pedrerol', 'goals' => 25));//*/

    $goles_double = array();
    $goles_last = array();//*/

    $goles_totales = array(); //Inicializa totales
    $goles_liga_cpy = $goles_liga; //copia, para luego meter solo restantes
    foreach ($goles_double as $double){
      $name = array_column($goles_liga_cpy, 'name'); //buscamos solo nombres
      $k = array_search($double['name'], $name); //busca en goles_liga
      if ($k){//si ha encontrado
        array_push($goles_totales, array('name' => $double['name'], 'goals' => $double['goals']+$goles_liga_cpy[$k]['goals']));
        unset($goles_liga_cpy[$k]);
      }else{
        array_push($goles_totales, array('name' => $double['name'], 'goals' => $double['goals']));
      }
    }
    //ahora añade al final los restantes de liga
    $goles_totales = array_merge($goles_totales, $goles_liga_cpy);

    foreach ($goles_last as $last){
      $name = array_column($goles_totales, 'name');
      $k = array_search($last['name'], $name);
      if ($k){
        $goles_totales[$k]['goals'] += $last['goals'];
      }else{
        array_push($goles_totales, array('name' => $last['name'], 'goals' => $last['goals']));
      }
    }

    //sort personalizado
    usort($goles_totales, function($a, $b) {
              return $a['goals'] < $b['goals'];
          });
    usort($goles_double, function($a, $b) {
              return $a['goals'] < $b['goals'];
          });
    usort($goles_last, function($a, $b) {
              return $a['goals'] < $b['goals'];
          });

    //solo top10 tras todo
    $goles_liga = array_slice($goles_liga, 0, 10, true);
    $goles_double = array_slice($goles_double, 0, 10, true);
    $goles_last = array_slice($goles_last, 0, 10, true);
    $goles_totales = array_slice($goles_totales, 0, 10, true);

  	return view('lofc/botaoro', compact('goles_liga', 'goles_double', 'goles_last', 'goles_totales'));
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

        
}