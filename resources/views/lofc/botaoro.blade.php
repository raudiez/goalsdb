@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Temporada {{$season_id}}</li>
  <li>Bota de Oro</li>
</ol>
<div class="page-header">
  <h1 class="premier">Bota de Oro</h1>
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
              @foreach ($leagues_goals as $league_name => $league_goals)
              <th style="text-align: center">{{$league_name}}</th>
              @endforeach
              @foreach ($competitions_goals as $competition_name => $competition_goals)
              @if (strpos($competition_name, 'Playoff') === false)
              <th style="text-align: center">{{$competition_name}}</th>
              @endif
              @endforeach
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

              <!-- COPAS -->
              @foreach ($competitions_goals as $competition_name => $competition)
                @if (strpos($competition_name, 'Playoff') === false)
                	<?php $found = FALSE; ?>
                	@foreach ($competition as $jugador_comp)
                		@if ($jugador['name'] == $jugador_comp['player_name'])
                		<?php 
                			$found = TRUE;
                			$goals_comp = $jugador_comp['goals'];
                		?>
                		@endif
                	@endforeach
                	@if ($found)
                		<td class="col-xs-1 col-md-1">{{$goals_comp}}</td>
                	@else 
                		<td class="col-xs-1 col-md-1">-</td>
                	@endif
                @endif
              @endforeach

              <!-- BOTA ORO -->
              <td class="col-xs-2 col-md-2">{{$jugador['goals']}}</td>
            </tr>
            @endforeach
          </tbody>
        </table></div>
        @else <p>No se ha podido conectar con Gesliga</p>
        @endif
      </div>
    </div>
	</div>
</div>
@endsection