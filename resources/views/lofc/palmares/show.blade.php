@extends('layouts.app')

@section('content')
<div class="container">
  <ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>LOFC</li>
    <li>Palmarés</li>
  </ol>
  <div class="page-header">
    <h1 class="premier" style="font-size: 32px;margin-left: 137px; margin-bottom: -46px">í</h1>
    <h1 class="premier">Palmares</h1>
  </div>
  <div class="row">
    <p>
      <?php echo html_entity_decode($palmaresText) ?>
    </p>
    @if (!Auth::guest())
    <p style="text-align: right;"><a href="{{ url('/lofc/palmares/form') }}" class="btn btn-lofc-primary" role="button" title="Editar texto" ><span class="glyphicon glyphicon-pencil"></span></a></p>
    @endif
  </div>
</div>

@endsection