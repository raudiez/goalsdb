@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Temporada {{$season_id}}</li>
  <li>Competiciones</li>
</ol>
@if ($season_calendar != '')
<div class="row">
  <div class="col-xs-12 col-md-12">
    <div class="page-header">
    <h1 class="premier">Calendario de la Temporada {{$season_id}}</h1>
  </div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#season_calendar" aria-expanded="false" aria-controls="season_calendar">
              Desplegar calendario »
            </a>
          </h4>
        </div>
        <div id="season_calendar" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <?php $season_calendar = str_replace('<table>', '<div class="table-responsive"><table class="table table-bordered">', $season_calendar);?>
            <?php $season_calendar = str_replace('</table>', '</table></div>', $season_calendar);?>
            <?php echo html_entity_decode($season_calendar) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
<div class="page-header">
  <h1 class="premier">Listado de competiciones de la temporada {{$season_id}}</h1>
</div>
<div class="row">
  @foreach ($competitions as $competition)
  @if ($competition->is_league)
  <div class="col-xs-12 col-md-4">
    <div class="list-group">
      <div class="list-group-item" style="text-align: center;height: 150px; position: relative;">
        <h3 class="list-group-item-heading" style="text-align: left">{{$competition->name}}</h3>
        <br/>
        <a href="http://www.gesliga.es/Clasificacion.aspx?Liga={{$competition->id_gesliga}}" target="_blank">Ir a <b>Gesliga</b></a>
        <br/><br/>
        <?php 
          $href_matches = '';
          if ($season_id == 1) {
            $href_matches = 'https://www.youtube.com/playlist?list=PLsydjHvwqKccfXnsUmfcmpq7jHMMdpOFy';
          }else{
            $href_matches = url('lofc/league_videos/'.$season_id.'/'.$competition->name);
          }
        ?>
        @if ($href_matches != '') 
        <a href="{{$href_matches}}" target="_blank">Ver partidos</a>
        @endif
      </div>
    </div>
  </div>
  @else
  <div class="col-xs-12 col-md-4">
    <div class="list-group">
      <a href="{{url('lofc/show_competition/'.$competition->id)}}" class="list-group-item" style="text-align: center;height: 150px; position: relative;" target="_blank">
        <h3 class="list-group-item-heading" style="text-align: left">{{$competition->name}}</h3>
        <br/>
        <p><b>Tipo de eliminatoria:</b> @if ($competition->round_trip) Ida y vuelta @else Solo ida @endif</p>
      </a>
    </div>
  </div>
  @endif
  @endforeach
  @if (!Auth::guest())
  <div class="col-xs-12 col-md-12">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-2">
        <a href="{{ url('/lofc/competitions/form_league/'.$season_id) }}" class="btn btn-lofc-success" role="button" title="Añadir liga"><span class="glyphicon glyphicon-plus-sign"></span> Añadir liga</a>
      </div>
      <div class="col-md-2">
        <a href="{{ url('/lofc/competitions/form_cup/'.$season_id) }}" class="btn btn-lofc-primary" role="button" title="Añadir copa"><span class="glyphicon glyphicon-plus-sign"></span> Añadir copa</a>
      </div>
      <div class="col-md-2">
        <a href="{{ url('/lofc/teams/modify/'.$season_id) }}" class="btn btn-danger" role="button" title="Modificar equipos"><span class="glyphicon glyphicon-pencil"></span> Modificar equipos</a>
      </div>
      <div class="col-md-2">
        <a href="{{ url('/lofc/seasons/calendar_form/'.$season_id) }}" class="btn btn-info" role="button" title="Modificar calendario"><span class="glyphicon glyphicon-pencil"></span> Modificar calendario</a>
      </div>
      <div class="col-md-2"></div>
    </div>
    @endif
    @if (!empty($gala))
      <div class="col-xs-12 col-md-12">
        <div class="page-header">
        <h1 class="premier">Gala Final</h1>
      </div>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseVid{{$gala['videoId']}}" aria-expanded="false" aria-controls="collapseVid{{$gala['videoId']}}">
                  Desplegar vídeo »
                </a>
              </h4>
            </div>
            <div id="collapseVid{{$gala['videoId']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$gala['videoId']}}"></iframe>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection