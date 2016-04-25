@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li><a href="{{ url('/teams') }}">Clubs</a></li>
    <li><a href="{{ url('/teams/show/'.$team->id) }}">{{$team->name}}</a></li>
    <li>Añadir record</li>
  </ol>
  <div class="page-header">
    <h1>Añadir record de goles</h1>
  </div>
  <div class="row">
    {!! Form::open(array('url' => 'records/save/'.$team->id)) !!}
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="form-group">
        {!!Form::label('goals', 'Gol')!!}
        {!! Form::text('goals', $new_record, array('class' => 'form-control')) !!}
      </div>
      <div class="form-group">
        {!!Form::label('player_id', 'Jugador')!!}
        <select name='player_id' class='form-control'>
          <option value="" disabled selected>Selecciona un jugador</option>
          @foreach ($players as $player)
            <option value="{{$player->id}}">{{$player->name}}</option>
          @endforeach

        </select>
      </div>
      {{Form::submit('Añadir', array('class' => 'btn btn-success'))}}
    </div>
    <div class="col-md-4"></div>

    {!! Form::close() !!}
  </div>
</div>
@endsection
