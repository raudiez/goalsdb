@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Crear temporada</li>
</ol>
<div class="page-header">
  <h1 class="premier">Inicializar temporada</h1>
</div>
<div class="row">
  {!! Form::open(array('url' => 'lofc/seasons/save')) !!}
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          {!! Form::label('teams_n', 'Inserte el número de equipos que se enfrentan esta temporada:') !!}
        </div>
        <div class="col-md-4">
          {!! Form::number('teams_n', 2, array('class' => 'form-control', 'min' => 2)) !!}
        </div>
        
      </div>
    </div>
    <div class="clearfix"><br/></div>
    {{Form::submit('Siguiente', array('class' => 'btn btn-lofc-success'))}}
  </div>
  <div class="col-md-2"></div>
  {!! Form::close() !!}
</div>

@endsection