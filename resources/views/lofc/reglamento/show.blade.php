@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Reglamento</li>
  </ol>
  <div class="page-header">
    <h1 class="premier">Reglamento</h1>
  </div>
  <div class="row reglamento">
    <div class="col-md-1"></div>
    <div class="col-md-10">
      <?php $reglamentoText = str_replace('<table>', '<div class="table-responsive"><table class="table table-bordered">', $reglamentoText);?>
      <?php $reglamentoText = str_replace('</table>', '</table></div>', $reglamentoText);?>
      <?php echo html_entity_decode($reglamentoText) ?>
    </div>
    <div class="col-md-1">
      @if (!Auth::guest())
      <p style="text-align: right;"><a href="{{ url('/lofc/reglamento/form') }}" class="btn btn-lofc-primary" role="button" title="Editar texto"><span class="glyphicon glyphicon-pencil"></span></a></p>
      @endif
    </div>
  </div>
</div>

@endsection