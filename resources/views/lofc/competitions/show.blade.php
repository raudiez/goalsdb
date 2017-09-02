@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Temporada {{$competition->id_season}}</li>
    <li><a href="{{url('lofc/competitions/'.$competition->id_season)}}">Competiciones</a></li>
    <li>{{$competition->name}}</li>
  </ol>
  <div class="page-header">
    <h1 class="premier">{{$competition->name}}</h1>
  </div>
  <div class="row equal">
  <?php $phase = 0; $showed = 0;?>
  @foreach ($junctions as $junction)
    <?php 
      if ($junction->phase != $phase) {
        $phase = $junction->phase;
        if ($phase != $showed) {
          $phase_name = preg_replace('/[0-9]+/', '', $junction->name);
          $phase_name = preg_replace('/\s$/', '', $phase_name);
          ?>
          <div class="col-xs-12 col-md-12">
            <h3 class="premier text-muted" style="text-align: center">
              {{$phase_name}}
            </h3>
          </div>
          <?php
          $showed = $phase;
        }
      }
    ?>
    @if ($junction->phase == 3)
    <div class="col-xs-12 col-md-3"></div>
    <div class="col-xs-12 col-md-6">
    @else
    <div class="col-xs-12 col-md-6">
    @endif
      <div class="panel panel-lofc-primary" style="height:92%;">
        <div class="panel-heading" style="text-align: center;"><b>{{$junction->name}}</b><br/>{{$junction->date}}</div>
        <div class="panel-body">
          <p style="text-align: center">
          @if ($junction->lofc_team_L_logo_img != '')
          {{ Html::image('imgs//lofc/teams/'.$junction->lofc_team_L_logo_img,'',array('style' => 'height: 50px; margin-right:5px;')) }}
          @endif
          {{$junction->lofc_team_L_name}} 
          <?php if (!$junction->played_1){ ?>
          - 
          <?php }elseif ($junction->second_leg && $junction->played_2) {
                  $goals_L = $junction->goals_L_1 + $junction->goals_L_2;
                  $goals_V = $junction->goals_V_1 + $junction->goals_V_2;
          ?>
          <b>{{$goals_L}}</b> - <b>{{$goals_V}}</b>
          <?php }else { 
                  $goals_L = $junction->goals_L_1;
                  $goals_V = $junction->goals_V_1;
            ?>
          <b>{{$goals_L}}</b> - <b>{{$goals_V}}</b>
          <?php } ?>
          {{$junction->lofc_team_V_name}} 
          @if ($junction->lofc_team_V_logo_img != '')
          {{ Html::image('imgs//lofc/teams/'.$junction->lofc_team_V_logo_img,'',array('style' => 'height: 50px;margin-left:5px;')) }}
          @endif</p>
          <p style="text-align: center">
          @if (!Auth::guest())
            @if ($junction->second_leg && !$junction->played_1)
            <b>Ida:</b> <a href="{{ url('/lofc/match_form/'.$junction->id.'/1') }}">Introducir resultado</a><br/>
            <b>Vuelta:</b> <a href="{{ url('/lofc/match_form/'.$junction->id.'/2') }}">Introducir resultado</a>
            @elseif ($junction->second_leg && $junction->played_1 && !$junction->played_2)
            <b>Ida:</b> <b>{{$junction->goals_L_1}}</b> - <b>{{$junction->goals_V_1}}</b>  <a href="{{ url('/lofc/match_form/'.$junction->id.'/1') }}">Modificar resultado</a><br/>
            <b>Vuelta:</b> <a href="{{ url('/lofc/match_form/'.$junction->id.'/2') }}">Introducir resultado</a>
            @elseif ($junction->second_leg && $junction->played_1 && $junction->played_2)
            <b>Ida:</b> <b>{{$junction->goals_L_1}}</b> - <b>{{$junction->goals_V_1}}</b>  <a href="{{ url('/lofc/match_form/'.$junction->id.'/1') }}">Modificar resultado</a><br/>
            <b>Vuelta:</b> <b>{{$junction->goals_V_2}}</b> - <b>{{$junction->goals_L_2}}</b>  <a href="{{ url('/lofc/match_form/'.$junction->id.'/2') }}">Modificar resultado</a>
            @elseif (!$junction->second_leg && !$junction->played_1)
            <a href="{{ url('/lofc/match_form/'.$junction->id.'/1') }}">Introducir resultado</a>
            @elseif (!$junction->second_leg && $junction->played_1)
            <a href="{{ url('/lofc/match_form/'.$junction->id.'/1') }}">Modificar resultado</a><br/>
            @endif
          @else
            @if ($junction->second_leg && !$junction->played_1)
            <b>Ida:</b> Por disputarse.<br/>
            <b>Vuelta:</b> Por disputarse.
            @elseif ($junction->second_leg && $junction->played_1 && !$junction->played_2)
            <b>Ida:</b> <b>{{$junction->goals_L_1}}</b> - <b>{{$junction->goals_V_1}}</b><br/>
            <b>Vuelta:</b> Por disputarse.
            @elseif ($junction->second_leg && $junction->played_1 && $junction->played_2)
            <b>Ida:</b> <b>{{$junction->goals_L_1}}</b> - <b>{{$junction->goals_V_1}}</b><br/>
            <b>Vuelta:</b> <b>{{$junction->goals_V_2}}</b> - <b>{{$junction->goals_L_2}}</b>
            @endif
          @endif
          </p>
          <p style="text-align: center">
            <?php 
            $notes = '';
            if ($junction->second_leg && $junction->played_1){
              if(preg_match('/Ida: (.+)\n/', $junction->notes, $matches))
                $notes = $matches[1];
              $match_goals_L = App\LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction->id, 1, $junction->id_L_team); //Goles ida L
              $match_goals_V = App\LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction->id, 1, $junction->id_V_team); //Goles ida V
              $goals_notes = '';
              foreach ($match_goals_L as $match_scorer_L){
                $goals_notes = $goals_notes.$match_scorer_L->player_name.'('.$match_scorer_L->count.') , ';
              }
              foreach ($match_goals_V as $match_scorer_V){
                $goals_notes = $goals_notes.$match_scorer_V->player_name.'('.$match_scorer_V->count.') , ';
              }
              if ($goals_notes != ''){
                $goals_notes = substr($goals_notes, 0, -3);
                if($notes != ''){
                  $notes = 'Goles: '.$goals_notes.'<br/>Crónica: '.$notes;
                }else{
                  $notes = 'Goles: '.$goals_notes;
                }
              }
              if($notes != ''){
            ?>
            <button type="button" class="btn btn-lofc-primary" data-container="body" data-html="true" data-toggle="popover" data-placement="top" data-content="{{$notes}}">Ver notas Ida</button>
            <?php }} ?>
            <?php 
            $notes2 = '';
            if ($junction->second_leg && $junction->played_2){
              if(preg_match('/Vuelta: (.+)/', $junction->notes, $matches))
                $notes2 = $matches[1];
              $match_goals_L = App\LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction->id, 2, $junction->id_L_team); //Goles vuelta L
              $match_goals_V = App\LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction->id, 2, $junction->id_V_team); //Goles vuelta V
              $goals_notes = '';
              foreach ($match_goals_V as $match_scorer_V){
                $goals_notes = $goals_notes.$match_scorer_V->player_name.'('.$match_scorer_V->count.') , ';
              }
              foreach ($match_goals_L as $match_scorer_L){
                $goals_notes = $goals_notes.$match_scorer_L->player_name.'('.$match_scorer_L->count.') , ';
              }
              if ($goals_notes != ''){
                $goals_notes = substr($goals_notes, 0, -3);
                if($notes2 != ''){
                  $notes2 = 'Goles: '.$goals_notes.'<br/>Crónica: '.$notes2;
                }else{
                  $notes2 = 'Goles: '.$goals_notes;
                }
              }
              if($notes2 != ''){
            ?>
            <button type="button" class="btn btn-lofc-primary" data-container="body" data-html="true" data-toggle="popover" data-placement="top" data-content="{{$notes2}}">Ver notas Vuelta</button>
            <?php }} ?>
            <?php
            if (!$junction->second_leg && $junction->played_1){
              $notes = $junction->notes;
            $match_goals_L = App\LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction->id, 1, $junction->id_L_team); //Goles L
            $match_goals_V = App\LOFCMatchesGoals::getByJunctionAndLegAndTeam($junction->id, 1, $junction->id_V_team); //Goles V
            $goals_notes = '';
            foreach ($match_goals_L as $match_scorer_L){
              $goals_notes = $goals_notes.$match_scorer_L->player_name.'('.$match_scorer_L->count.') , ';
            }
            foreach ($match_goals_V as $match_scorer_V){
              $goals_notes = $goals_notes.$match_scorer_V->player_name.'('.$match_scorer_V->count.') , ';
            }
            if ($goals_notes != ''){
              $goals_notes = substr($goals_notes, 0, -3);
              if($notes != ''){
                $notes = 'Goles: '.$goals_notes.'<br/>Crónica: '.$notes;
              }else{
                $notes = 'Goles: '.$goals_notes;
              }
            }
            if($notes != ''){
            ?>
            <button type="button" class="btn btn-lofc-primary" data-container="body" data-html="true" data-toggle="popover" data-placement="top" data-content="{{$notes}}">Ver notas</button>
            <?php }} ?>            
          </p>
          <center>
            <?php 
              if ($junction->ended){
                if (!empty($videos)) {
                  foreach ($videos as $video) {
                    if (strpos($video->snippet->title, $competition->name.' | '.$junction->lofc_team_L_name.' '.$goals_L.' - '.$goals_V.' '.$junction->lofc_team_V_name)) {
                      ?>
                      <a href="https://www.youtube.com/watch?v={{$video->id->videoId}}" target="_blank">Ver vídeo »</a>
                      <?php
                    }
                  }
                }
              }
            ?>
          </center>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>


@endsection