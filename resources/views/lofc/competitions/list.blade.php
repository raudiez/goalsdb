@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Temporada {{$season_id}}</li>
    <li>Competiciones</li>
  </ol>
  <div class="page-header">
    <h1 class="premier">Listado de competiciones de la temporada {{$season_id}}</h1>
  </div>
  <div class="row">
    @foreach ($competitions as $competition)
    @if ($competition->is_league)
    <div class="col-xs-12 col-md-4">
      <div class="list-group">
        <div class="list-group-item" style="text-align: center;height: 150px; position: relative;">
          <h3 class="list-group-item-heading" style="text-align: left">{{$competition->name}}</h3>
          <br/>
          <a href="http://www.gesliga.es/Clasificacion.aspx?Liga={{$competition->id_gesliga}}" target="_blank">Ir a <b>Gesliga</b></a>
          <br/><br/>
          <?php 
            $href_matches = '';
            if ($season_id == 1) {
              $href_matches = 'https://www.youtube.com/playlist?list=PLsydjHvwqKccfXnsUmfcmpq7jHMMdpOFy';
            }else{
              $href_matches = url('lofc/league_videos/'.$season_id.'/'.$competition->name);
            }
          ?>
          @if ($href_matches != '') 
          <a href="{{$href_matches}}" target="_blank">Ver partidos</a>
          @endif
        </div>
      </div>
    </div>
    @else
    <div class="col-xs-12 col-md-4">
      <div class="list-group">
        <a href="{{url('lofc/show_competition/'.$competition->id)}}" class="list-group-item" style="text-align: center;height: 150px; position: relative;">
          <h3 class="list-group-item-heading" style="text-align: left">{{$competition->name}}</h3>
          <br/>
          <p><b>Tipo de eliminatoria:</b> @if ($competition->round_trip) Ida y vuelta @else Solo ida @endif</p>
        </a>
      </div>
    </div>
    @endif
    @endforeach
    @if (!Auth::guest())
    <div class="col-xs-12 col-md-12">
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-2">
          <a href="{{ url('/lofc/competitions/form_league/'.$season_id) }}" class="btn btn-lofc-success" role="button" title="Añadir liga"><span class="glyphicon glyphicon-plus-sign"></span> Añadir liga</a>
        </div>
        <div class="col-md-2">
          <a href="{{ url('/lofc/competitions/form_cup/'.$season_id) }}" class="btn btn-lofc-primary" role="button" title="Añadir copa"><span class="glyphicon glyphicon-plus-sign"></span> Añadir copa</a>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
    @endif
  </div>

</div>


@endsection