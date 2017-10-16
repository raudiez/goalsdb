@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Temporada {{$season_id}}</li>
  <li><a href="{{url('lofc/competitions/'.$season_id)}}">Competiciones</a></li>
  <li>{{$league_name}}</li>
  <li>Vídeos de partidos</li>
</ol>
<div class="page-header">
  <h1>Vídeos de la {{$league_name}}</h1>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      @if(!empty($jornadas))
      @foreach ($jornadas as $key => $jornada)
        <h3>Jornada {{$key}}</h3>
        @foreach ($jornada as $video)
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseVid{{$video['videoId']}}" aria-expanded="false" aria-controls="collapseVid{{$video['videoId']}}">
                {{$video['title']}}
              </a>
            </h4>
          </div>
          <div id="collapseVid{{$video['videoId']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
              <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$video['videoId']}}"></iframe>
            </div>
            </div>
          </div>
        </div>
        @endforeach
      @endforeach
      @else
      <p>Aún no hay vídeos esta temporada.</p>
      @endif
    </div>
  </div>
</div>

@endsection