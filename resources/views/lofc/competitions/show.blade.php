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
    <h1>{{$competition->name}}</h1>
  </div>
  <div class="row">
  <?php $phase = 1; ?>
  @foreach ($junctions as $junction)
    @if ($junction->phase == 3)
    <div class="col-xs-12 col-md-3"></div>
    <div class="col-xs-12 col-md-6">
    <div class="col-xs-12 col-md-3"></div>
    @else
    <div class="col-xs-12 col-md-6">
    @endif
      <div class="panel panel-primary">
        <div class="panel-heading" style="text-align: center;"><b>{{$junction->name}}</b></div>
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
          <?php }else { ?>
          <b>{{$junction->goals_L_1}}</b> - <b>{{$junction->goals_V_1}}</b>
          <?php } ?>
          {{$junction->lofc_team_V_name}} 
          @if ($junction->lofc_team_V_logo_img != '')
          {{ Html::image('imgs//lofc/teams/'.$junction->lofc_team_V_logo_img,'',array('style' => 'height: 50px;margin-left:5px;')) }}
          @endif</p>
          <p style="text-align: center">
          @if ($junction->second_leg && !$junction->played_1)
          <b>Ida:</b> Por disputarse.<br/>
          <b>Vuelta:</b> Por disputarse.
          @elseif ($junction->second_leg && $junction->played_1 && !$junction->played_2)
          <b>Ida:</b> <b>{{$junction->goals_L_1}}</b> - <b>{{$junction->goals_V_1}}</b><br/>
          <b>Vuelta:</b> Por disputarse.
          @elseif ($junction->second_leg && $junction->played_1 && $junction->played_2)
          <b>Ida:</b> <b>{{$junction->goals_L_1}}</b> - <b>{{$junction->goals_V_1}}</b><br/>
          <b>Vuelta:</b> <b>{{$junction->goals_L_2}}</b> - <b>{{$junction->goals_V_2}}</b>
          @endif
          </p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>


@endsection