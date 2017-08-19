<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\LOFCCompetition;
use App\LOFCSeason;
use App\LOFCJunction;
use App\LOFCTeam;
use App\LOFCPlayer;
use App\LOFCMatchesGoals;
use App\LOFCGoals;

use Illuminate\Http\Request;

use App\Http\Requests;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use RuntimeException;

use Alaouy\Youtube\Facades\Youtube;

class LOFCController extends Controller{

  public function botaoro($season_id){
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

  public function competitions($season_id){
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
    ///*
    

    //*/
    $params = array(
        'q'             => 'LOFC '.$competition->name.' TEMPORADA'.$competition->id_season,
        'type'          => 'video',
        'part'          => 'id, snippet',
        'maxResults'    => 50
    );
    $videos = Youtube::searchAdvanced($params);
    return view('lofc/competitions/show', compact('competition', 'junctions', 'videos'));
  }

  public function match_form($junction_id, $leg){
    $junction = LOFCJunction::joinJunction_Teams($junction_id)['0'];
    $players_L = LOFCPlayer::getByTeamID($junction->id_L_team);
    $players_V = LOFCPlayer::getByTeamID($junction->id_V_team);
    $competition = LOFCCompetition::getByID($junction->id_competition);
    $match_goals_L = LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction_id, $leg, $junction->id_L_team);
    $match_goals_V = LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction_id, $leg, $junction->id_V_team);

    $notes = '';
    if ($junction->second_leg && $leg == 1){
      if(preg_match('/Ida: (.+)\n/', $junction->notes, $matches))
        $notes = $matches[1];
    }elseif ($junction->second_leg && $leg == 2){
      if(preg_match('/Vuelta: (.+)\n/', $junction->notes, $matches))
        $notes = $matches[1];
    }else{ //Partido único.
      $notes = $junction->notes;
    }
    return view('lofc/competitions/matches/form', compact('competition', 'junction', 'leg', 'players_L', 'players_V', 'match_goals_L', 'match_goals_V', 'notes'));
  }

  public function match_save(Request $request, $junction_id, $leg){
    $this->validate($request, [
        'count' => 'required|min:1',
        'player_id' => 'bail|required:not_in:0',
    ]);
    $count = $request->input('count');
    $player_id = $request->input('player_id');
    $player = LOFCPlayer::getByID($player_id);
    $junction = LOFCJunction::getByID($junction_id);
    LOFCMatchesGoals::insertNew($player_id, $player->id_team, $junction_id, $leg, $count);
    LOFCGoals::insertOrUpdate($player_id, $junction->id_competition, $count);
    if ($player->id_team == $junction->id_L_team){
      LOFCJunction::updateGoals($junction_id, 'L', $leg, $count);
    }else LOFCJunction::updateGoals($junction_id, 'V', $leg, $count);
    return redirect('lofc/match_form/'.$junction_id.'/'.$leg);
  }

  public function junction_save(Request $request, $junction_id, $leg){
    $notes = $request->input('notes');
    $junction = LOFCJunction::getByID($junction_id);
    $ended = $junction->ended;
    $played_1 = $junction->played_1;
    $played_2 = $junction->played_2;
    $db_notes = $junction->notes;

    if ($junction->second_leg && $leg == 1){
      if ($notes != '') {
        if(preg_match('/Ida: (.+)\n/', $db_notes, $matches)){
          $notes = preg_replace('/Ida: (.+)\n/', "Ida: ".$notes."\n", $db_notes, 1);
        }else{
          $notes = $db_notes."Ida: ".$notes."\n";
        }
      }
      $played_1 = 1;
    }elseif ($junction->second_leg && $leg == 2){
      if ($notes != '') {
        if(preg_match('/Vuelta: (.+)\n/', $db_notes, $matches)){
          $notes = preg_replace('/Vuelta: (.+)\n/', "Vuelta: ".$notes."\n", $db_notes, 1);
        }else{
          $notes = $db_notes."Vuelta: ".$notes."\n";
        }
      }
      $played_2 = 1;
      $ended = 1;
    }else{ //Partido único, terminado.
      $played_1 = 1;
      $ended = 1;
    }
    LOFCJunction::updateJunctionMatch($junction_id, $played_1, $played_2, $ended, $notes);
    return redirect('lofc/show_competition/'.$junction->id_competition);
  }

  public function players_form($team_id, $junction_id, $leg){
    $team = LOFCTeam::getByID($team_id);
    return view('lofc/players/form', compact('team', 'junction_id', 'leg'));
  }

  public function players_save(Request $request, $team_id){
    $player_name = $request->input('player_name');
    $junction_id = $request->input('junction_id');
    $leg = $request->input('leg');
    LOFCPlayer::insertNew($player_name,$team_id);
    return redirect('lofc/match_form/'.$junction_id.'/'.$leg);
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