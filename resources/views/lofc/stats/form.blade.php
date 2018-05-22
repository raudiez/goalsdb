@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Estadísticas históricas</li>
</ol>
<div class="page-header">
	<h1 class="premier" style="font-size: 32px;margin-left: 105px; margin-bottom: -55px">´</h1>
  <h1 class="premier" style="font-size: 32px;margin-left: 315px; margin-bottom: -46px">´</h1>
  <h1 class="premier">Estadisticas historicas</h1>
</div>
<div class="row reglamento">
  {!! Form::open(array('url' => 'lofc/stats/save', 'autocomplete' => 'off')) !!}
  {!! Form::textarea('statsText', $statsText, array('class' => 'form-control', 'rows' => '20', 'id' => 'statstextarea')) !!}
      <div class="clearfix"><br/></div>
  {{Form::submit('Guardar', array('class' => 'btn btn-danger'))}}
  {!! Form::close() !!}
</div>
@endsection