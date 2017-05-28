@extends('layouts.app')

@section('content')
<div class="container">
@if (!Auth::guest())
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading" style="text-align: center;"><b>Goles totales en la BD</b></div>
        <div class="panel-body">
          <center><b>{{$total_goals}}</b></center>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading" style="text-align: center;"><b>Goles totales de cada equipo {{ Html::image('imgs/fifa16_onlynum.png','',array('style' => 'height: 12px; margin-right: 8px;margin-top: -3px; margin-left: 5px;')) }}</b></div>
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
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading" style="text-align: center;"><b>Goles totales de cada Entrenador</b></div>
        <div class="panel-body">
          <div class="table-responsive"><table class="table table-striped table-hover">
            <thead>
              <tr>
                <th style="text-align: right;">Pos</th>
                <th style="text-align: center">Entrenador</th>
                <th style="text-align: center">Goles totales</th>
              </tr>
            </thead>
            <tbody style="text-align: center">
              <?php $i=1; ?>
              @foreach ($goals_by_owner as $owner_goals)
              <tr>
                <!-- POS -->
                <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
                <?php $i++; ?>

                <!-- CLUB -->
                <td class="col-xs-7 col-md-7" style="text-align: left">{{$owner_goals->owner_name}}</td>

                <!-- GOLES CLUB -->
                <td class="col-xs-4 col-md-4">{{$owner_goals->total_goals}}</td>
              </tr>
              @endforeach
            </tbody>
          </table></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading" style="text-align: center;"><b>Goles totales de cada equipo {{ Html::image('imgs/fifa17_onlynum.png','',array('style' => 'height: 12px; margin-right: 8px;margin-top: -3px; margin-left: 5px;')) }}</b></div>
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
              @foreach ($goals_by_club_17 as $team_goals)
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
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading"><b>Clasifiación total {{ Html::image('imgs/fifa16_onlynum.png','',array('style' => 'height: 12px; margin-right: 8px;margin-top: -3px; margin-left: 5px;')) }}</b>  </div>
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
              @foreach ($players16 as $player)
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
    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading"><b>Clasifiación total {{ Html::image('imgs/fifa17_onlynum.png','',array('style' => 'height: 12px; margin-right: 8px;margin-top: -3px; margin-left: 5px;')) }}</b>  </div>
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
              @foreach ($players17 as $player)
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
                <td class="col-xs-3 col-md-3">{{$player->goals_club_17}}</td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table></div>
        </div>
      </div>
    </div>
  </div>
@else
  <center>
  <h1 style="font-family: PremierLeague;">Bienvenido a la <b>LOFC</b></h1>
  <div class="clearfix" style="margin-top: 40px;"><br/></div>
  {{ Html::image('imgs/lofc.png','',array('style' => 'height: 250px')) }}
  </center>
@endif
</div>
@endsection


