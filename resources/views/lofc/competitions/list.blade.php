@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Temporada {{$season->id}}</li>
    <li>Competiciones</li>
  </ol>
  <div class="page-header">
    <h1>Listado de competiciones de la temporada {{$season->id}}</h1>
  </div>
  <div class="row">
    <div class="col-xs-12 col-md-4">
      <div class="list-group">
        <a href="http://www.gesliga.es/Clasificacion.aspx?Liga={{$season->id_gesliga}}" class="list-group-item" style="text-align: center;height: 150px; position: relative;" target="_blank">
          <h3 class="list-group-item-heading" style="text-align: left">{{$gesliga_name}}</h3>
          <br/>
          <p style="text-align: center;">Ir a <b>Gesliga</b></p>
        </a>
      </div>
    </div>
    @foreach ($competitions as $competition)
    <div class="col-xs-12 col-md-4">
      <div class="list-group">
        <a href="{{url('lofc/show_competition/'.$competition->id)}}" class="list-group-item" style="text-align: center;height: 150px; position: relative;">
          <h3 class="list-group-item-heading" style="text-align: left">{{$competition->name}}</h3>
          <br/>
          <p><b>Tipo de eliminatoria:</b> @if ($competition->round_trip) Ida y vuelta @else Solo ida @endif</p>
        </a>
      </div>
    </div>
    @endforeach
  </div>

</div>


@endsection