@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li><a href="{{ url('/teams') }}">Clubs</a></li>
    <li><a href="{{ url('/teams/show/'.$team->id) }}">{{$team->name}}</a></li>
    <li>Añadir jugador a {{$team->name}}</li>
  </ol>
  <div class="page-header">
    <h1>Añadir jugador</h1>
  </div>
  <div class="row">
    {!! Form::open(array('url' => 'players/save/'.$team->id)) !!}
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="form-group">
        {!! Form::label('player_name', 'Nombre de jugador') !!}
        {!! Form::text('player_name', null, array('class' => 'form-control')) !!}
      </div>
      {{Form::submit('Añadir', array('class' => 'btn btn-success'))}}
    </div>
    <div class="col-md-4"></div>
    {!! Form::close() !!}
  </div>
</div>
@endsection