@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>{{$season_name}}</li>
</ol>
<div class="page-header">
  <h1 class="premier">Calendario de {{$season_name}}</h1>
</div>
<div class="row reglamento">
  {!! Form::open(array('url' => 'lofc/seasons/calendar_save/'.$season_id , 'autocomplete' => 'off')) !!}
  {!! Form::textarea('calendarText', $calendarText, array('class' => 'form-control', 'rows' => '20', 'id' => 'calendartextarea')) !!}
      <div class="clearfix"><br/></div>
  {{Form::submit('Guardar', array('class' => 'btn btn-danger'))}}
  {!! Form::close() !!}
</div>
@endsection