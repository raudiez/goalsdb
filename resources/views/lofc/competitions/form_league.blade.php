@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Temporada {{$season_id}}</li>
    <li>Añadir liga</li>
  </ol>
  <div class="page-header">
    <h1 class="premier">Nueva liga de la temporada {{$season_id}}</h1>
  </div>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 form-group">
      {!! Form::open(array('url' => 'lofc/competitions/save_league/'.$season_id)) !!}
      {!! Form::label('name', 'Nombre:') !!}
      {!! Form::text('name', null , array('class' => 'form-control')) !!}
      <div class="clearfix"><br/></div>
      <div class="row">
        <div class="col-md-8 col-xs-12">
          {!! Form::label('id_gesliga', 'ID de Gesliga:') !!}
        </div>
        <div class="col-md-4 col-xs-12">
          {!! Form::text('id_gesliga', null , array('class' => 'form-control')) !!}
        </div>
      </div>
      <div class="clearfix"><br/></div>
      {{Form::submit('Guardar', array('class' => 'btn btn-danger'))}}
      {!! Form::close() !!}
    </div>
  </div>

</div>


@endsection