@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Modificar equipos de la temporada {{$season_id}}</li>
</ol>
<div class="page-header">
  <h1 class="premier">Modificar equipos</h1>
</div>
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <p>En esta sección debes editar los nombres y escudos de los equipos de la temporada. Si no encuentras el escudo del equipo que quieras editar, puedes subir uno nuevo.</p>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach ($lofc_teams as $lofc_team)
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#team{{$lofc_team->id}}" aria-expanded="false" aria-controls="team{{$lofc_team->id}}">
              {{Html::image('imgs/lofc/teams/'.$lofc_team->logo_img,'',array('style' => 'height: 30px; margin-right:5px;')) }}  {{$lofc_team->name}} - Editar
            </a>
          </h4>
        </div>
        <div id="team{{$lofc_team->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
          {!! Form::open(array('url' => 'lofc/teams/save/'.$lofc_team->id)) !!}
          {{Form::hidden('season_id', $season_id)}}
          {!! Form::label('team_name', 'Nombre del equipo:') !!}
          {!! Form::text('team_name', $lofc_team->name, array('class' => 'form-control')) !!}

          <div class="clearfix"><br/></div>
          {!! Form::label('logo_img', 'Selecciona un escudo:') !!}
          <select class="image-picker" name="logo_img">
              <option value="" data-img-src='' data-img-class="custom-img-picker" data-img-alt="Elige logo">Elige logo</option>
            @foreach ($lofc_teams_logos as $lofc_team_logo)
              <option value="{{$lofc_team_logo->logo_img}}" data-img-src='{{url("imgs/lofc/teams/".$lofc_team_logo->logo_img)}}' data-img-class="custom-img-picker" data-img-alt="{{$lofc_team_logo->logo_img}}" @if($lofc_team_logo->logo_img == $lofc_team->logo_img) selected="true" @endif>{{$lofc_team_logo->logo_img}}</option>
            @endforeach
          </select>
          <script>
            $("select").imagepicker({
              hide_select : true,
              show_label  : false
            });
            $("select").data('picker').sync_picker_with_select();
          </script>

          <div class="clearfix"><br/></div>
          {{Form::submit('Guardar', array('class' => 'btn btn-lofc-success'))}}  
          {!! Form::close() !!}
        
          <div class="clearfix"><br/></div>

          </div>
        </div>
      </div>
    @endforeach
    </div>


  </div>
  <div class="col-md-2"></div>
</div>

@endsection