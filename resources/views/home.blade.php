@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

    <div class="col-md-9">
      <div class="panel panel-primary">
        <div class="panel-heading"><b>Clasifiación total Fifa 16</b>  </div>
        <div class="panel-body">
          <div class="table-responsive"><table class="table table-striped table-hover">
            <thead>
              <tr>
                <th style="text-align: right;">Pos</th>
                <th>Jugador</th>
                <th style="text-align: center">Club</th>
                <th style="text-align: center">Goles Club</th>
              </tr>
            </thead>
            <tbody style="text-align: center">
              <?php $i=1; ?>
              @foreach ($players as $player)
              @if($player->name != 'RESTO')
              <tr>
                <!-- POS -->
                <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
                <?php $i++; ?>

                <!-- JUGADOR -->
                <td class="col-xs-4 col-md-4" style="text-align: left">{{$player->name}}</td>

                <!-- CLUB -->
                <td class="col-xs-4 col-md-4" style="text-align: left">{{$player->team_name}}</td>

                <!-- GOLES CLUB -->
                <td class="col-xs-3 col-md-3">{{$player->goals_club_16}}</td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table></div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="panel panel-primary">
        <div class="panel-heading"><b>Goles totales en la BD</b></div>
        <div class="panel-body">
          <center><b>{{$total_goals}}</b></center>
        </div>
      </div>
      <div class="panel panel-primary">
        <div class="panel-heading"><b>Goles totales de cada equipo (16)</b></div>
        <div class="panel-body">
          <div class="table-responsive"><table class="table table-striped table-hover">
            <thead>
              <tr>
                <th style="text-align: right;">Pos</th>
                <th style="text-align: center">Club</th>
                <th style="text-align: center">Goles totales</th>
              </tr>
            </thead>
            <tbody style="text-align: center">
              <?php $i=1; ?>
              @foreach ($goals_by_club_16 as $team_goals)
              <tr>
                <!-- POS -->
                <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
                <?php $i++; ?>

                <!-- CLUB -->
                <td class="col-xs-7 col-md-7" style="text-align: left">{{$team_goals->team_name}}</td>

                <!-- GOLES CLUB -->
                <td class="col-xs-4 col-md-4">{{$team_goals->total_goals}}</td>
              </tr>
              @endforeach
            </tbody>
          </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


