@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Copas</li>
  </ol>
  <div class="page-header">
    <h1>Listado de Copas</h1>
  </div>
  <div class="row">
    @foreach ($competitions as $competition)
    <div class="col-xs-12 col-md-3">
      <div class="list-group">
        <h4 class="list-group-item-heading" style="text-align: left">{{$competition->name}}</h4>
        <p>Tipo de partido: {{$competition->matches}}</p>
      </div>
    </div>
    @endforeach
  </div>

</div>


@endsection