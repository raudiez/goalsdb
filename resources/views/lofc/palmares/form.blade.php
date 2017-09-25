@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Palmarés</li>
  </ol>
  <div class="page-header">
    <h1 class="premier" style="font-size: 32px;margin-left: 137px; margin-bottom: -46px">´</h1>
    <h1 class="premier">Palmares</h1>
  </div>
  <div class="row">
    {!! Form::open(array('url' => 'lofc/palmares/save')) !!}
    {!! Form::textarea('palmaresText', $palmaresText, array('class' => 'form-control', 'rows' => '20', 'id' => 'palmarestextarea')) !!}
        <div class="clearfix"><br/></div>
    {{Form::submit('Guardar', array('class' => 'btn btn-danger'))}}
    {!! Form::close() !!}
  </div>
</div>

@endsection