@extends('layouts.app')

@section('content')
<div class="container">
	<ol class="breadcrumb">
    <li><a href="{{ url('/') }}">Inicio</a></li>
    <li>Contacto</li>
  </ol>
  <div class="page-header">
    <h1 class="premier">Formulario de contacto</h1>
  </div>
  <div class="row">
  	<div class="col-md-12">
  	@if(count($errors->all()) > 0)
			  <div class="alert alert-danger" role="alert"> <p><b>Attenzione!</b></p>
			    <ul>
			      @foreach($errors->all() as $error)
			        <li>{{ $error }}</li>
			      @endforeach
			    </ul>
			  </div>
			@endif
  		<p>Puedes utilizar este formulario de contacto para contactar con nosotros, expresarnos cualquier duda, sugerencia o queja.</p>
  	</div>
	  <div class="col-md-3"></div>
	  <div class="col-md-6">
	    {!! Form::open(array('url' => 'contact_send')) !!}
	    {!! Form::label('subject', 'Asunto:') !!}
	    {!! Form::text('subject', null, array('class' => 'form-control', 'placeholder' => 'Refleja si es una sugerencia u otro tipo de mensaje')) !!}
	    <div class="clearfix"><br/></div>
	    {!! Form::label('subject', 'Texto:') !!}
	    {!! Form::textarea('message_text', null, array('class' => 'form-control', 'rows' => '10', 'placeholder' => 'Escribe aquí tu mensaje. Si lo desea, deje un mail de contacto en el mensaje.')) !!}
	    <div class="clearfix"><br/></div>
	    <div class="clearfix"><br/></div>
	    {{Form::submit('Enviar', array('class' => 'btn btn-danger'))}}
	    {!! Form::close() !!}
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
@endsection


