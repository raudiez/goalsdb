@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Temporada 2</li>
    <li>Bota de Oro</li>
  </ol>
  <div class="page-header">
    <h1>Bota de Oro</h1>
  </div>
	<div class="row">
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-primary">
	        <div class="panel-heading" style="text-align: center;"><b>Liga</b></div>
	        <div class="panel-body">
	          <div class="table-responsive"><table class="table table-striped table-hover">
	            <thead>
	              <tr>
	              	<th style="text-align: right;">Pos</th>
	                <th style="text-align: left;">Jugador</th>
	                <th style="text-align: center">Goles</th>
	              </tr>
	            </thead>
	            <tbody style="text-align: center">
	              <?php $i=1; ?>
	              @foreach ($goles_liga as $jugador)
	              <tr>
	                <!-- POS -->
	                <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
	                <?php $i++; ?>
	                <!-- JUGADOR -->
	                <td class="col-xs-7 col-md-7" style="text-align: left">{{$jugador['name']}}</td>

	                <!-- GOLES -->
	                <td class="col-xs-4 col-md-4">{{$jugador['goals']}}</td>
	              </tr>
	              @endforeach
	            </tbody>
	          </table></div>
	        </div>
	      </div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-primary">
	        <div class="panel-heading" style="text-align: center;"><b>Double Game Championship</b></div>
	        <div class="panel-body">
	          <div class="table-responsive"><table class="table table-striped table-hover">
	            <thead>
	              <tr>
	              	<th style="text-align: right;">Pos</th>
	                <th style="text-align: left;">Jugador</th>
	                <th style="text-align: center">Goles</th>
	              </tr>
	            </thead>
	            <tbody style="text-align: center">
	              <?php $i=1; ?>
	              @foreach ($goles_double as $jugador)
	              <tr>
	                <!-- POS -->
	                <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
	                <?php $i++; ?>
	                <!-- JUGADOR -->
	                <td class="col-xs-7 col-md-7" style="text-align: left">{{$jugador['name']}}</td>

	                <!-- GOLES -->
	                <td class="col-xs-4 col-md-4">{{$jugador['goals']}}</td>
	              </tr>
	              @endforeach
	            </tbody>
	          </table></div>
	        </div>
	      </div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-primary">
	        <div class="panel-heading" style="text-align: center;"><b>Last Man Standing Tournament</b></div>
	        <div class="panel-body">
	          <div class="table-responsive"><table class="table table-striped table-hover">
	            <thead>
	              <tr>
	              	<th style="text-align: right;">Pos</th>
	                <th style="text-align: left;">Jugador</th>
	                <th style="text-align: center">Goles</th>
	              </tr>
	            </thead>
	            <tbody style="text-align: center">
	              <?php $i=1; ?>
	              @foreach ($goles_last as $jugador)
	              <tr>
	                <!-- POS -->
	                <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
	                <?php $i++; ?>
	                <!-- JUGADOR -->
	                <td class="col-xs-7 col-md-7" style="text-align: left">{{$jugador['name']}}</td>

	                <!-- GOLES -->
	                <td class="col-xs-4 col-md-4">{{$jugador['goals']}}</td>
	              </tr>
	              @endforeach
	            </tbody>
	          </table></div>
	        </div>
	      </div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-primary">
	        <div class="panel-heading" style="text-align: center;"><b>Bota de Oro</b></div>
	        <div class="panel-body">
	          <div class="table-responsive"><table class="table table-striped table-hover">
	            <thead>
	              <tr>
	              	<th style="text-align: right;">Pos</th>
	                <th style="text-align: left;">Jugador</th>
	                <th style="text-align: center">Goles</th>
	              </tr>
	            </thead>
	            <tbody style="text-align: center">
	              <?php $i=1; ?>
	              @foreach ($goles_totales as $jugador)
	              <tr>
	                <!-- POS -->
	                <td class="col-xs-1 col-md-1" style="text-align: right"><b>{{$i}}</b></td>
	                <?php $i++; ?>
	                <!-- JUGADOR -->
	                <td class="col-xs-7 col-md-7" style="text-align: left">{{$jugador['name']}}</td>

	                <!-- GOLES -->
	                <td class="col-xs-4 col-md-4">{{$jugador['goals']}}</td>
	              </tr>
	              @endforeach
	            </tbody>
	          </table></div>
	        </div>
	      </div>
		</div>
	</div>
</div>






@endsection