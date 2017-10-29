@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Añadir jugador a {{$team->name}}</li>
</ol>
<div class="page-header">
  <h1 class="premier">Nuevo jugador</h1>
</div>
<div class="row">
  {!! Form::open(array('url' => 'lofc/players_save/'.$team->id)) !!}
  {{Form::hidden('junction_id', $junction_id)}}
  {{Form::hidden('leg', $leg)}}
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('player_name', 'Nombre de jugador') !!}
      {!! Form::text('player_name', null, array('class' => 'form-control')) !!}
    </div>
    {{Form::submit('Añadir', array('class' => 'btn btn-lofc-success'))}}
  </div>
  <div class="col-md-4"></div>
  {!! Form::close() !!}
</div>
@endsection