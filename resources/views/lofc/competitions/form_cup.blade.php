@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Temporada {{$season_id}}</li>
  <li>Añadir copa</li>
</ol>
<div class="page-header">
  <h1 class="premier">Nueva copa de la temporada {{$season_id}}</h1>
</div>
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6 form-group">
    {!! Form::open(array('url' => 'lofc/competitions/save_cup/'.$season_id)) !!}
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null , array('class' => 'form-control')) !!}
    <div class="clearfix"><br/></div>
    <div class="row">
      <div class="col-md-10 col-xs-12">
        {!! Form::label('num_teams', 'Número de participantes:') !!}
      </div>
      <div class="col-md-2 col-xs-12">
        {!! Form::number('num_teams', 2, array('class' => 'form-control', 'min' => '2')) !!}
      </div>
    </div>
    <div class="clearfix"><br/></div>
    <div class="row">
      <div class="col-md-10 col-xs-12">
        {!! Form::label('round_trip', 'Ida y vuelta:') !!}
      </div>
      <div class="col-md-2 col-xs-12">
        {!! Form::checkbox('round_trip', 'round_trip', false) !!}
      </div>
    </div>
    <div class="clearfix"><br/></div>
    {{Form::submit('Guardar', array('class' => 'btn btn-danger'))}}
    {!! Form::close() !!}
  </div>
</div>
@endsection