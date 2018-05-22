@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Reglamento</li>
</ol>
<div class="page-header">
  <h1 class="premier">Reglamento</h1>
</div>
<div class="row reglamento">
  {!! Form::open(array('url' => 'lofc/reglamento/save', 'autocomplete' => 'off')) !!}
  {!! Form::textarea('reglamentoText', $reglamentoText, array('class' => 'form-control', 'rows' => '20', 'id' => 'reglamentotextarea')) !!}
      <div class="clearfix"><br/></div>
  {{Form::submit('Guardar', array('class' => 'btn btn-danger'))}}
  {!! Form::close() !!}
</div>
@endsection