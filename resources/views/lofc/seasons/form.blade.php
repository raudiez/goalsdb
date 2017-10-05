@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>Nueva temporada</li>
  </ol>
  <div class="page-header">
    <h1 class="premier">Nueva temporada</h1>
  </div>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <a href="{{ url('/lofc/seasons/save') }}" class="btn btn-lofc-primary" role="button" title="Añadir temporada">Añadir nueva temporada</a>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
@endsection