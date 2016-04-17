@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li>Equipos</li>
  </ol>
  <div class="page-header">
    <h1>Equipos</h1>
  </div>
  <div class="row">
    @foreach ($teams as $team)
    <div class="col-sm-4">
      <div class="list-group">
        <a href="{{ url('/teams/show/'.$team->id) }}" class="list-group-item" style="text-align: center;height: 300px; position: relative;">
          <h4 class="list-group-item-heading" style="text-align: left">{{$team->name}}</h4>
          <img src="{{URL::asset('imgs/teams/'.$team->logo.'.png')}}" alt="{{$team->name}}" style="height: 75%; margin: 15px 0 15px 0;">
        </a>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
