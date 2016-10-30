@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>Entrenadores</li>
  </ol>
  <div class="page-header">
    <h1>Entrenadores</h1>
  </div>
  <div class="row">
    @foreach ($owners as $owner)
    <div class="col-xs-12 col-md-3">
      <div class="list-group">
        <a href="{{ url('/owners/show/'.$owner->id) }}" class="list-group-item" style="text-align: center;height: 300px; position: relative;">
          <h4 class="list-group-item-heading" style="text-align: left">{{$owner->name}}</h4>
          {{ Html::image('imgs/owners/'.$owner->name.'.png',$owner->name,array('style' => 'height: 75%; margin: 15px 0 15px 0;')) }}
        </a>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
