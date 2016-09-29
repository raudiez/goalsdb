@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>Directivo</li>
  </ol>
  <div class="page-header">
    <h1>{{$owner->name}}: Clubs del directivo</h1>
  </div>
  <div class="row">
    @foreach ($clubs as $club)
    <div class="col-xs-12 col-md-3">
      <div class="list-group">
        <a href="{{ url('/teams/show/'.$club->id) }}" class="list-group-item" style="text-align: center;height: 300px; position: relative;">
          <h4 class="list-group-item-heading" style="text-align: left">{{$club->name}}</h4>
          {{ Html::image('imgs/teams/'.$club->logo.'.png',$club->name,array('style' => 'height: 75%; margin: 15px 0 15px 0;')) }}
          <h1 class="list-group-item-heading" style="text-align: right; color: rgba(44, 44, 44, 0.6); margin-top: -30px; font-size: 50px;"><i><b>{{$club->version}}</b></i></h1>
        </a>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

