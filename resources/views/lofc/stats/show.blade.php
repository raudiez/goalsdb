@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}">Inicio</a></li>
  <li>LOFC</li>
  <li>Estadísticas históricas</li>
</ol>
<div class="page-header">
  <h1 class="premier" style="font-size: 32px;margin-left: 105px; margin-bottom: -55px">´</h1>
  <h1 class="premier" style="font-size: 32px;margin-left: 315px; margin-bottom: -46px">´</h1>
  <h1 class="premier">Estadisticas historicas</h1>
</div>
<div class="row stats">
  <div class="col-md-1"></div>
  <div class="col-md-10">
    <?php $statsText = str_replace('<table>', '<div class="table-responsive"><table class="table table-bordered">', $statsText);?>
    <?php $statsText = str_replace('</table>', '</table></div>', $statsText);?>
    <?php echo html_entity_decode($statsText) ?>
  </div>
  <div class="col-md-1">
    @if (!Auth::guest())
    <p style="text-align: right;"><a href="{{ url('/lofc/stats/form') }}" class="btn btn-lofc-primary" role="button" title="Editar texto"><span class="glyphicon glyphicon-pencil"></span></a></p>
    @endif
  </div>
</div>
@endsection