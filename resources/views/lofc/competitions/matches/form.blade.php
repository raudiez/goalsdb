@extends('layouts.app')

@section('content')

<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Temporada {{$competition->id_season}}</li>
    <li><a href="{{url('lofc/competitions/'.$competition->id_season)}}">Competiciones</a></li>
    <li><a href="{{url('lofc/show_competition/'.$competition->id)}}">{{$competition->name}}</a></li>
    <li>{{$junction->name}}</li>
  </ol>
  <div class="page-header">
    <h2>{{$competition->name}} - {{$junction->name}} 
    @if ($junction->second_leg && $leg == 1)
     - Partido de ida
    @elseif ($junction->second_leg && $leg == 2)
     - Partido de vuelta
    @endif
    </h2>
  </div>
  <div class="row">
  	<div class="col-xs-12 col-md-12">
  		<h3 style="text-align: center;"> 
  		<?php
  			if ($leg == 1){
  				$goals_L = $junction->goals_L_1;
  				$goals_V = $junction->goals_V_1;
  				$logo_L = Html::image('imgs//lofc/teams/'.$junction->lofc_team_L_logo_img,'',array('style' => 'height: 50px;margin-left:5px;'));
  				$logo_V = Html::image('imgs//lofc/teams/'.$junction->lofc_team_V_logo_img,'',array('style' => 'height: 50px;margin-left:5px;'));
  				$team_name_L = $junction->lofc_team_L_name;
  				$team_id_L = $junction->id_L_team;
  				$team_name_V = $junction->lofc_team_V_name;
  				$team_id_V = $junction->id_V_team;
  				$select_players_L = array();
			  	foreach ($players_L as $player) {
			  		$select_players_L[$player->id] = $player->name;
			  	}
			  	$select_players_V = array();
			  	foreach ($players_V as $player) {
			  		$select_players_V[$player->id] = $player->name;
			  	}
			  }elseif ($junction->second_leg && $leg == 2){
  				$goals_L = $junction->goals_V_2;
  				$goals_V = $junction->goals_L_2;
  				//Intercambia goleadores
  				$aux = $match_goals_L;
  				$match_goals_L = $match_goals_V;
  				$match_goals_V = $aux;
  				//
  				$logo_L = Html::image('imgs//lofc/teams/'.$junction->lofc_team_V_logo_img,'',array('style' => 'height: 50px;margin-left:5px;'));
  				$logo_V = Html::image('imgs//lofc/teams/'.$junction->lofc_team_L_logo_img,'',array('style' => 'height: 50px;margin-left:5px;'));
  				$team_name_L = $junction->lofc_team_V_name;
  				$team_id_L = $junction->id_V_team;
  				$team_name_V = $junction->lofc_team_L_name;
  				$team_id_V = $junction->id_L_team;
  				$select_players_L = array();
			  	foreach ($players_V as $player) {
			  		$select_players_L[$player->id] = $player->name;
			  	}
			  	$select_players_V = array();
			  	foreach ($players_L as $player) {
			  		$select_players_V[$player->id] = $player->name;
			  	}
			  }
  		?>
  		{{ $logo_L }} {{$team_name_L.' '.$goals_L}} - {{$goals_V.' '.$team_name_V}} {{ $logo_V }}</h3>
  		</div>
		  <div class="clearfix"><br/></div>
		  <div class="clearfix"><br/></div>
	  	<div class="col-xs-12 col-md-6">
	      <div class="list-group">
	        <div class="list-group-item" style="text-align: center; position: relative;">
	          <h4 class="list-group-item-heading" style="text-align: left">Goleadores {{$team_name_L}}</h4>
	          @foreach ($match_goals_L as $match_scorer_L)
	          <p>{{$match_scorer_L->player_name.' : '.$match_scorer_L->count}}</p>
	          @endforeach
	        </div>
	      </div>
	    </div>
	    <div class="col-xs-12 col-md-6">
	      <div class="list-group">
	        <div class="list-group-item" style="text-align: center; position: relative;">
	          <h4 class="list-group-item-heading" style="text-align: left">Goleadores {{$team_name_V}}</h4>
	          @foreach ($match_goals_V as $match_scorer_V)
	          <p>{{$match_scorer_V->player_name.' : '.$match_scorer_V->count}}</p>
	          @endforeach
	        </div>
	      </div>
	    </div>
	    <div class="clearfix"><br/></div>
	    <div class="clearfix"><br/></div>
	  	<div class="col-xs-12 col-md-6">
	  		<h4 style="text-align: center">{{ $logo_L }} {{$team_name_L}}</h4>
	  		{!! Form::open(array('url' => 'lofc/match_save/'.$junction->id.'/'.$leg)) !!}
	  		<div class="col-xs-1 col-md-1"></div>
		  	<div class="col-xs-1 col-md-1"><a href="{{ url('/lofc/players_form/'.$team_id_L.'/'.$junction->id.'/'.$leg) }}" class="btn btn-lofc-primary" role="button" title="Añadir jugador"><span class="glyphicon glyphicon-plus-sign"></span></a></div>
		  	<div class="col-xs-7 col-md-7">{!! Form::select('player_id', $select_players_L, null, array('class' => 'form-control', 'placeholder' => 'Selecciona un jugador...')) !!}</div>
		  	<div class="col-xs-2 col-md-2">{!! Form::number('count', '1', array('class' => 'form-control', 'min' => '1')) !!}</div>
		  	<div class="clearfix"><br/></div>
		  	<div class="clearfix"><br/></div>
		  	{{Form::submit('Guardar goleador', array('class' => 'btn btn-lofc-success'))}}
		  	{!! Form::close() !!}
	  	</div>
	  	<div class="col-xs-12 col-md-6">
	  		<h4 style="text-align: center">{{ $logo_V }} {{$team_name_V}}</h4>
	  		{!! Form::open(array('url' => 'lofc/match_save/'.$junction->id.'/'.$leg)) !!}
	  		<div class="col-xs-1 col-md-1"></div>
		  	<div class="col-xs-1 col-md-1"><a href="{{ url('/lofc/players_form/'.$team_id_V.'/'.$junction->id.'/'.$leg) }}" class="btn btn-lofc-primary" role="button" title="Añadir jugador"><span class="glyphicon glyphicon-plus-sign"></span></a></div>
		  	<div class="col-xs-7 col-md-7">{!! Form::select('player_id', $select_players_V, null, array('class' => 'form-control', 'placeholder' => 'Selecciona un jugador...')) !!}</div>
		  	<div class="col-xs-2 col-md-2">{!! Form::number('count', '1', array('class' => 'form-control', 'min' => '1')) !!}</div>
		  	<div class="clearfix"><br/></div>
		  	<div class="clearfix"><br/></div>
		  	{{Form::submit('Guardar goleador', array('class' => 'btn btn-lofc-success'))}}
		  	{!! Form::close() !!}
	  	</div>
	  	<div class="clearfix"><br/></div>
		  <div class="clearfix"><br/></div>
		  <div class="clearfix"><br/></div>
	  	<div class="col-xs-12 col-md-3"></div>
	    <div class="col-xs-12 col-md-6" style="text-align: center">
		    <p>Si ya ha añadido todos los goles, añada notas si es necesario, y finalice el partido.</p>
		    {!! Form::open(array('url' => 'lofc/junction_save/'.$junction->id.'/'.$leg)) !!}
		    @if ($notes == '')
		    	{!! Form::textarea('notes', null, array('class' => 'form-control', 'rows' => '4', 'placeholder' => 'Notas del partido...')) !!}
		    @else
		    	{!! Form::textarea('notes', $notes, array('class' => 'form-control', 'rows' => '4')) !!}
		    @endif
		    <div class="clearfix"><br/></div>
		  	<div class="clearfix"><br/></div>
		    {{Form::submit('Finalizar partido', array('class' => 'btn btn-danger'))}}
		  	{!! Form::close() !!}
		    {{-- <a href="{{ url('lofc/junction_save/'.$junction->id.'/'.$leg) }}" class="btn btn-danger" role="button">Finalizar partido</a> --}}
	    </div>
	    <div class="col-xs-12 col-md-3"></div>

  </div>{{-- ROW --}}
</div>{{-- CONTAINER --}}

{{-- TODO: SELECT VALIDATOR (mostrar errores). BORRAR UN GOLEADOR (Y QUE SE APLIQUE A GOALS, MATCHES_GOALS Y JUNCTION) --}}

@endsection