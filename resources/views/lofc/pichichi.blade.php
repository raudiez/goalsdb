@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Temporada {{$season_id}}</li>
  <li>Pichichi de Liga</li>
</ol>
<div class="page-header">
  <h1 class="premier">Pichichi</h1>
</div>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<div class="panel panel-lofc-primary">
      <div class="panel-heading" style="text-align: center;"><b>Clasificación de la temporada {{$season_id}}</b></div>
      <div class="panel-body">
      	@if (!empty($leagues_goals))
      	<div class="table-responsive"><table class="table table-striped table-hover">
          <thead>
            <tr>
            	<th style="text-align: right;">Pos</th>
              <th style="text-align: left;">Jugador</th>
              @if(array_key_exists('group_name', $jugador))
              <th style="text-align: center">Grupo</th>
              @endif
              <th style="text-align: center">Goles</th>
            </tr>
          </thead>
          <tbody style="text-align: center">
            <?php $i=1; ?>
            @foreach ($goles_totales as $jugador)
            <tr>
              <!-- POS -->
              <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
              <?php $i++; ?>
              <!-- JUGADOR -->
              <td class="col-xs-2 col-md-2" style="text-align: left">{{$jugador['name']}}</td>
              <!-- GRUPO -->
              @if(isset($jugador['group_name']))
              <td class="col-xs-1 col-md-1">{{$jugador['group_name']}}</td>
              @endif
              <!-- GOLES -->
              <td class="col-xs-2 col-md-2">{{$jugador['goals']}}</td>
            </tr>
            @endforeach
          </tbody>
        </table></div>
        @else <p>No se ha podido conectar o no hay datos en Gesliga.</p>
        @endif
      </div>
    </div>
	</div>
</div>
@endsection