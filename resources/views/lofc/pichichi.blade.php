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
              @if (count($leagues_goals) > 1)
                @foreach ($leagues_goals as $league_name => $league_goals)
                <th style="text-align: center">{{$league_name}}</th>
                @endforeach
              @endif
              <th style="text-align: center">Total</th>
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
              @if (count($leagues_goals) > 1)
                <!-- LIGAS -->
                @foreach ($leagues_goals as $league_name => $league)
                  <?php $found = FALSE; ?>
                  @foreach ($league as $jugador_lig)
                    @if ($jugador['name'] == $jugador_lig['name'])
                    <?php 
                      $found = TRUE;
                      $goals_lig = $jugador_lig['goals'];
                    ?>
                    @endif
                  @endforeach
                  @if ($found)
                    <td class="col-xs-1 col-md-1">{{$goals_lig}}</td>
                  @else 
                    <td class="col-xs-1 col-md-1">-</td>
                  @endif
                @endforeach
              @endif

              <!-- PICHICHI -->
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