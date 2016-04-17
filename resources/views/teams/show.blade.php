@extends('layouts.app')

@section('content')
<?php
    $total_goals_club = 0;
    $total_goals_career = 0;
    $total_goals = 0;
    $total_goals_without = 0;
    $resto_goals = 0;
    foreach ($players as $player) {
        if ($player->name != 'RESTO'){
            $total_goals_club += $player->goals_club;
            $total_goals_career += $player->goals_career;
        }else{
            $resto_goals = $player->goals_club;
        }
    }
    $total_goals_without = $total_goals_club + $total_goals_career;
    $total_goals = $total_goals_without + $resto_goals;
?>
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('/teams') }}">Equipos</a></li>
    <li>{{$team->name}}</li>
  </ol>
  <div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <img src="{{URL::asset('imgs/teams/'.$team->logo.'.png')}}" alt="{{$team->name}}" style="width: 100%; margin-left: 30px;">
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
        <div class="page-header">
            <h1>{{ $team->name }}</h1>
          </div>
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <h3><span class="label label-primary">Total: {{$total_goals}}</span></h3>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <h3><span class="label label-success">Total Club: {{$total_goals_club}}</span></h3>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <h3><span class="label label-info">Total Carrera: {{$total_goals_career}}</span></h3>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <h3><span class="label label-danger">Total sin RESTO: {{$total_goals_without}}</span></h3>
            </div>
        </div>
    </div>
  </div>
  <div class="clearfix"><br/></div>
  <div class="clearfix"><br/></div>
  <div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    </div>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="text-align: right">Pos</th>
                    <th>Jugador</th>
                    <th style="text-align: center">Goles Club</th>
                    <th style="text-align: center">% Club</th>
                    <th style="text-align: center">Goles Carrera</th>
                    <th style="text-align: center">% Carrera</th>
                    <th style="text-align: center">Goles totales</th>
                    <th style="text-align: center">% del Total</th>
                    <th style="text-align: center">% del Total sin <i>RESTO</i></th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                <?php $pos = 1; ?>
                @foreach ($players as $player)
                @if($player->name != 'RESTO')
                <tr>
                    <!-- POS -->
                    <td style="text-align: right;"><b>{{$pos}}</b></td>
                    <?php $pos++; ?>

                    <!-- JUGADOR -->
                    <td style="text-align: left">{{$player->name}}</td>

                    <!-- GOLES CLUB -->
                    <td><span class="glyphicon glyphicon-minus" aria-hidden="true" style="margin-right: 8px;font-size: 10px"></span>{{$player->goals_club}}<span class="glyphicon glyphicon-plus" aria-hidden="true" style="margin-left: 8px;font-size: 10px"></span></td>

                    <!-- % CLUB -->
                    @if ($total_goals_club > 0)
                        <td>{{number_format(($player->goals_club/100)/($total_goals_club/100)*100,2)}}</td>
                    @else
                        <td>0.00</td>
                    @endif

                    <!-- GOLES CARRERA -->
                    <td>{{$player->goals_career}}</td>

                    <!-- % CARRERA -->
                    @if ($total_goals_career > 0)
                        <td>{{number_format(($player->goals_career/100)/($total_goals_career/100)*100,2)}}</td>
                    @else
                        <td>0.00</td>
                    @endif

                    <!-- GOLES TOTALES -->
                    <td>{{$player->goals_club+$player->goals_career}}</td>

                    <!-- % DEL TOTAL -->
                    @if ($total_goals > 0)
                        <td>{{number_format((($player->goals_club+$player->goals_career)/100)/($total_goals/100)*100,2)}}</td>
                    @else
                        <td>0.00</td>
                    @endif

                    <!-- % DEL TOTAL SIN RESTO -->
                    @if ($total_goals_without > 0)
                        <td>{{number_format((($player->goals_club+$player->goals_career)/100)/($total_goals_without/100)*100,2)}}</td>
                    @else
                        <td>0.00</td>
                    @endif
                </tr>
                @endif
                @endforeach

                <!-- FILA DE "RESTO" -->
                <tr>
                    <td style="text-align: right;"><b>{{$pos}}</b></td>
                    <td style="text-align: left"><b>RESTO</b></td>
                    <td><b>-</b></td>
                    <td><b>-</b></td>
                    <td><b>-</b></td>
                    <td><b>-</b></td>
                    <td><b>{{$resto_goals}}</b></td>
                    <td><b>-</b></td>
                    <td><b>-</b></td>
                </tr>
            </tbody>
        </table>
    </div>
  </div>
</div>
@endsection

