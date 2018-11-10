@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>{{$season_name}}</li>
  <li><a href="{{url('lofc/competitions/'.$season_id)}}">Competiciones</a></li>
  <li>{{$competition->name}}</li>
  <li>Modificar cruce</li>
</ol>
<div class="page-header">
  <h1 class="premier">Modificar cruce</h1>
  <h2 class="premier">{{$competition->name}} - {{$junction->name}} </h2>
</div>
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <p>En esta sección debes editar los equipos a disputar un cruce.</p>
  </div>
  <div class="col-md-2"></div>
  <div class="clearfix"><br/></div>
  <div class="clearfix"><br/></div>
  {!! Form::open(array('url' => 'lofc/junctions/update/'.$season_id.'/'.$junction->id)) !!}
  <div class="col-md-2"></div>
  <div class="col-xs-12 col-md-4">
    <h4 style="text-align: center">Equipo local</h4>
    <select name="L_team" class="form-control">
      @foreach ($lofc_teams as $team)
      <option value="{{$team->id}}" @if($team->id == $junction->id_L_team) selected="true" @endif>{{$team->name}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-xs-12 col-md-4">
    <h4 style="text-align: center">Equipo visitante</h4>
    <select name="V_team" class="form-control">
      @foreach ($lofc_teams as $team)
      <option value="{{$team->id}}" @if($team->id == $junction->id_V_team) selected="true" @endif>{{$team->name}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-2"></div>
  <div class="clearfix"><br/></div>
  <div class="clearfix"><br/></div>
  <div class="col-md-5"></div>
  <div class="col-md-2">
  {{Form::submit('Guardar', array('class' => 'btn btn-lofc-success'))}}  
  </div>
  <div class="col-md-5"></div>
  {!! Form::close() !!}
  <div class="clearfix"><br/></div>
</div>
@endsection