@extends('layouts.app')

@section('content')
<?php
  $total_goals_club = 0;
  $total_goals_career = 0;
  $total_goals = 0;
  $total_goals_without = 0;
  $resto_goals = 0;
  $resto_id = 0;
  $j=0;
  $old_goals=[];
  foreach ($players as $player) {
    if ($player->name != 'RESTO'){
      $total_goals_club += $player->goals_club;
      $total_goals_career += $player->goals_career;
      $old_goals[$j]=array('id' => $player->id, 'name' => $player->name, 'goals_club' => $player->goals_club, 'goals_career' => $player->goals_career);
      $new_goals[$j]=array('id' => $player->id, 'name' => $player->name, 'goals_club' => $player->goals_club, 'goals_career' => $player->goals_career);
      $j++;
    }else{
      $resto_goals = $player->goals_club;
      $resto_id = $player->id;
    }
  }
  $old_goals[$j]=array('id' => $resto_id, 'name' => 'RESTO', 'goals_club' => $resto_goals, 'goals_career' => 0);
  $new_goals[$j]=array('id' => $resto_id, 'name' => 'RESTO', 'goals_club' => $resto_goals, 'goals_career' => 0);

  $total_goals_without = $total_goals_club + $total_goals_career;
  $total_goals = $total_goals_without + $resto_goals;

?>
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li><a href="{{ url('/teams') }}">Clubs</a></li>
    <li>{{$team->name}}</li>
  </ol>
  <div class="row">
    <div class="col-xs-2 col-md-2">
      {{ Html::image('imgs/teams/'.$team->logo.'.png',$team->name,array('style' => 'width: 100%; margin-left: 30px;')) }}
    </div>
    <div class="col-xs-8 col-md-8 col-xs-offset-1 col-md-offset-1">
      <div class="page-header">
          <h1>{{ $team->name }}</h1>
        </div>
      <div class="row">
        <div class="col-xs-10 col-md-3">
          <h3><span class="label label-primary">Total: {{$total_goals}}</span></h3>
        </div>
        <div class="col-xs-10 col-md-3">
          <h3><span class="label label-success">Total Club: {{$total_goals_club}}</span></h3>
        </div>
        <div class="col-xs-10 col-md-3">
          <h3><span class="label label-info">Total Carrera: {{$total_goals_career}}</span></h3>
        </div>
        <div class="col-xs-10 col-md-3">
          <h3><span class="label label-danger">Total sin RESTO: {{$total_goals_without}}</span></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"><br/></div>
  <div class="clearfix"><br/></div>

  {!! Form::open(array('url' => 'teams/save/'.$team->id)) !!}
  <div class="row">
    <div class="col-xs-10 col-md-10">
      <div class="table-responsive"><table class="table table-striped table-hover">
        <thead class="row">
          <tr>
            <th class="col-xs-1 col-md-1" style="text-align: right">Pos</th>
            <th class="col-xs-1 col-md-1" >Jugador</th>
            <th class="col-xs-2 col-md-2" style="text-align: center">Goles Club <span class="caret"></span></th>
            <th class="col-xs-1 col-md-1" style="text-align: center">% Club</th>
            <th class="col-xs-2 col-md-2" style="text-align: center">Goles Carrera</th>
            <th class="col-xs-1 col-md-1" style="text-align: center">% Carrera</th>
            <th class="col-xs-2 col-md-2" style="text-align: center">Goles totales</th>
            <th class="col-xs-1 col-md-1" style="text-align: center">% del Total</th>
            <th class="col-xs-1 col-md-1" style="text-align: center">% del Total sin <i>RESTO</i></th>
          </tr>
        </thead>
        <tbody style="text-align: center" class="row">
          <?php $i=1; $k=0; ?>
          @for ($j = 0; $j < count($new_goals); $j++)
          @if($new_goals[$j]['name'] != 'RESTO')
          <tr>
            <!-- POS -->
            <td class="col-xs-1 col-md-1" style="text-align: right; vertical-align:middle"><b>{{$k+1}}</b></td>
            {{Form::hidden('new_goals['.$k.'][id]', $new_goals[$j]['id'])}}

            <!-- JUGADOR -->
            <td class="col-xs-1 col-md-1" style="text-align: left; vertical-align:middle">{{$new_goals[$j]['name']}}</td>
            {{Form::hidden('new_goals['.$k.'][name]', $new_goals[$j]['name'])}}

            <!-- GOLES CLUB -->
            <td class="col-xs-2 col-md-2" style="vertical-align:middle">
              <div class="row">
                <div class="col-xs-1 col-md-2"></div>
                <div class="col-xs-10 col-md-8">
                  <div class="input-group row">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number btn-xs" style="height:34px;" data-type="minus" data-field="{{'new_goals['.$k.'][goals_club]'}}">
                        <span class="glyphicon glyphicon-minus"></span>
                      </button>
                    </span>
                    <input type="text" name="{{'new_goals['.$k.'][goals_club]'}}" class="form-control input-number" value="{{$new_goals[$j]['goals_club']}}" min="0" style="text-align: center;">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number btn-xs" style="height:34px;" data-type="plus" data-field="{{'new_goals['.$k.'][goals_club]'}}">
                        <span class="glyphicon glyphicon-plus"></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="col-xs-1 col-md-2"></div>
              </div>
            </td>
            <!-- % CLUB -->
            @if ($total_goals_club > 0)
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">{{number_format(($new_goals[$j]['goals_club']/100)/($total_goals_club/100)*100,2)}}</td>
            @else
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">0.00</td>
            @endif

            <?php $i++; ?>

            <!-- GOLES CARRERA -->
            <td class="col-xs-2 col-md-2" style="vertical-align:middle">
              <div class="row">
                <div class="col-xs-1 col-md-2"></div>
                <div class="col-xs-10 col-md-8">
                  <div class="input-group row">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number btn-xs" style="height:34px;" data-type="minus" data-field="{{'new_goals['.$k.'][goals_career]'}}">
                        <span class="glyphicon glyphicon-minus"></span>
                      </button>
                    </span>
                    <input type="text" name="{{'new_goals['.$k.'][goals_career]'}}" class="form-control input-number" value="{{$new_goals[$j]['goals_career']}}" min="0" style="text-align: center;">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number btn-xs" style="height:34px;" data-type="plus" data-field="{{'new_goals['.$k.'][goals_career]'}}">
                        <span class="glyphicon glyphicon-plus"></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="col-xs-1 col-md-2"></div>
              </div>
            </td>

            <?php $i++; ?>

            <!-- % CARRERA -->
            @if ($total_goals_career > 0)
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">{{number_format(($new_goals[$j]['goals_career']/100)/($total_goals_career/100)*100,2)}}</td>
            @else
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">0.00</td>
            @endif

            <!-- GOLES TOTALES -->
            <td class="col-xs-2 col-md-2" style="vertical-align:middle">{{$new_goals[$j]['goals_club']+$new_goals[$j]['goals_career']}}</td>

            <!-- % DEL TOTAL -->
            @if ($total_goals > 0)
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">{{number_format((($new_goals[$j]['goals_club']+$new_goals[$j]['goals_career'])/100)/($total_goals/100)*100,2)}}</td>
            @else
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">0.00</td>
            @endif

            <!-- % DEL TOTAL SIN RESTO -->
            @if ($total_goals_without > 0)
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">{{number_format((($new_goals[$j]['goals_club']+$new_goals[$j]['goals_career'])/100)/($total_goals_without/100)*100,2)}}</td>
            @else
              <td class="col-xs-1 col-md-1" style="vertical-align:middle">0.00</td>
            @endif
          </tr>
          <?php $k++; ?>
          @endif
          @endfor

          <!-- FILA DE "RESTO" -->
          <tr>
            <td class="col-xs-1 col-md-1" style="text-align: right;"><b>{{$k+1}}</b></td>
            {{Form::hidden('new_goals['.$k.'][id]', $new_goals[$j-1]['id'])}}
            <td class="col-xs-1 col-md-1" style="text-align: left"><b>RESTO</b></td>
            {{Form::hidden('new_goals['.$k.'][name]', $new_goals[$j-1]['name'])}}
            <td class="col-xs-2 col-md-2" style="vertical-align:middle"><b>-</b></td>
            <td class="col-xs-1 col-md-1" style="vertical-align:middle"><b>-</b></td>
            <td class="col-xs-2 col-md-2" style="vertical-align:middle"><b>-</b></td>
            <td class="col-xs-1 col-md-1" style="vertical-align:middle"><b>-</b></td>
            <td class="col-xs-2 col-md-2" style="vertical-align:middle">
              <div class="row">
                <div class="col-xs-1 col-md-2"></div>
                <div class="col-xs-10 col-md-8">
                  <div class="input-group row">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number btn-xs" style="height:34px;" data-type="minus" data-field="{{'new_goals['.$k.'][goals_club]'}}">
                        <span class="glyphicon glyphicon-minus"></span>
                      </button>
                    </span>
                    <input type="text" name="{{'new_goals['.$k.'][goals_club]'}}" class="form-control input-number" value="{{$resto_goals}}" min="0" style="text-align: center;">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number btn-xs" style="height:34px;" data-type="plus" data-field="{{'new_goals['.$k.'][goals_club]'}}">
                        <span class="glyphicon glyphicon-plus"></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="col-xs-1 col-md-2"></div>
              </div>
              {{Form::hidden('new_goals['.$k.'][goals_career]', $new_goals[$j-1]['goals_career'])}}
            </td>
            <td class="col-xs-1 col-md-1" style="vertical-align:middle"><b>-</b></td>
            <td class="col-xs-1 col-md-1" style="vertical-align:middle"><b>-</b></td>
          </tr>
        </tbody>
      </table></div>
    </div>

    <div class="col-xs-2 col-md-2">
      {{Form::submit('Guardar', array('class' => 'btn btn-success'))}}
      <div class="clearfix"><br/></div>
      <div class="panel panel-primary">
        <div class="panel-heading"><b>Records de goles</b></div>
        <div class="panel-body">
          <table class="table table-striped table-hover">
            <thead class="row">
              <tr>
                <th class="col-xs-3 col-md-3" style="text-align: right;vertical-align:middle">Gol</th>
                <th class="col-xs-9 col-md-9">Jugador</th>
              </tr>
            </thead>
            <tbody style="text-align: left" class="row">
              @foreach ($records as $record)
              <tr>
                <!-- RECORD -->
                <td class="col-xs-3 col-md-3" style="text-align: right;vertical-align:middle"><b>{{$record->goals}}</b></td>

                <!-- JUGADOR -->
                <td class="col-xs-9 col-md-9" style="vertical-align:middle">{{$record->player_name}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="clearfix"><br/></div>

      <a href="{{ url('/records/form/'.$team->id) }}" class="btn btn-danger" role="button">Añadir record</a>

    </div>

    {{Form::hidden('old_goals', serialize($old_goals))}}
  </div>
</div>
{!! Form::close() !!}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  $('.btn-number').click(function(e){
    e.preventDefault();
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
      if(type == 'minus') {
        if(currentVal > 0) {
          input.val(currentVal - 1).change();
        }
        if(currentVal == 0) {
          $(this).attr('disabled', true);
        }
      } else if(type == 'plus') {
        if(currentVal >= 0) {
          $(".btn-number[data-type='minus'][data-field='"+fieldName+"']").removeAttr('disabled')
        }//*/
        input.val(currentVal + 1).change();
      }
    } else {
        input.val(0);
    }
  });
  $(".input-number").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
          // let it happen, don't do anything
      return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
  });
</script>
@endsection

