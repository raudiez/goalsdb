@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>Directivo</li>
  </ol>
  <div class="page-header">
    <h1>Clubs del directivo</h1>
  </div>
  <div class="row">
    @foreach ($teams as $team)
    <div class="col-xs-12 col-md-3">
      <div class="list-group">
        <a href="{{ url('/teams/show/'.$team->id) }}" class="list-group-item" style="text-align: center;height: 300px; position: relative;">
          <h4 class="list-group-item-heading" style="text-align: left">{{$team->name}}</h4>
          {{ Html::image('imgs/teams/'.$team->logo.'.png',$team->name,array('style' => 'height: 75%; margin: 15px 0 15px 0;')) }}
        </a>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

