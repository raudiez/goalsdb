@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Clasifiación total</div>

                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Jugador</th>
                                <th style="text-align: center">Goles Club</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            @foreach ($players as $player)
                            @if($player->name != 'RESTO')
                            <tr>
                                <!-- JUGADOR -->
                                <td style="text-align: left">{{$player->name}}</td>

                                <!-- GOLES CLUB -->
                                <td>{{$player->goals_club}}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
