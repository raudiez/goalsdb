<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ URL::asset('imgs/lofc.png') }}" />
  <title>LOFC - Liga Online de Fútbol entre Caballeros</title>

  <!-- Fonts -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
  <link href="{{ URL::asset('css/premier-league/style.css') }}" rel='stylesheet' type='text/css'>

  <!-- Styles -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

  <style>
    .fa-btn {
      margin-right: 6px;
    }
    .table-hover > tbody > tr:hover {
      background-color: #C0C2CD;
    }
  </style>

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=cobce5u2ujmkx8bm6g0xxrhynbz9tc96j4iieol3h84h3sx6"></script>
  <script>tinymce.init({ selector:'#palmarestextarea'});</script>
  <script>tinymce.init({ selector:'#reglamentotextarea', plugins: "link,toc,image,lists,table", image_caption: true});</script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<!--style="background-image:url('imgs/index.jpeg');"-->
<body id="app-layout" >
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">

        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">{{ Html::image('imgs/lofc.png','',array('style' => 'height: 90%;')) }}
        </a>
      </div>

      <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="{{ url('/') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="font-family: PremierLeague; font-size: 26px; margin-left: -10px;"><b>LOFC</b> <span class="caret"></span></a>
            <ul class="dropdown-menu" style="margin-left: -10px;">
            @foreach ($lofc_seasons as $season)
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Temporada {{$season->id}}</a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">Temporada {{$season->id}}</li>
                  <li role="separator" class="divider"></li>
                  <li><a href="{{url('lofc/competitions/'.$season->id)}}">Competiciones</a></li>
                  <li><a href="{{url('lofc/pichichi/'.$season->id)}}">Pichichi</a></li>
                  <li><a href="{{url('lofc/botaoro/'.$season->id)}}">Bota de Oro</a></li>
                </ul>
              </li>
            @endforeach
            <li role="separator" class="divider"></li>
            @if (!Auth::guest())
            <li><a href="{{url('lofc/seasons/form')}}"><b><span class="glyphicon glyphicon-plus" style="font-size: 12px;"></span> Nueva temporada</b></a></li>
            <li role="separator" class="divider"></li>
            @endif
            <li><a href="{{url('lofc/palmares')}}">Palmarés</a></li>
            <li><a href="{{url('lofc/reglamento')}}">Reglamento</a></li>
            </ul>
          </li>
          @if (!Auth::guest())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrenadores <span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li><a href="{{url('/owners')}}">Todos</a></li>
              <li role="separator" class="divider"></li>
              @foreach ($owners as $owner_link)
                <li><a href="{{url('/owners/show/'.$owner_link->id)}}">
                <b>{{$owner_link->name}}</b></a></li>
              @endforeach
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clubs <span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li><a href="{{url('/teams')}}">Todos</a></li>
              <li role="separator" class="divider"></li>
              @foreach ($teams as $team_link)
                <li><a href="{{url('/teams/show/'.$team_link->id)}}">
                {{ Html::image('imgs/teams/'.$team_link->logo.'.png','',array('style' => 'height: 12px; margin-right: 8px;margin-top: -3px; margin-left: 0px;')) }}
                {{$team_link->name}} {{ Html::image('imgs/fifa'.$team_link->version.'_onlynum.png','',array('style' => 'height: 12px; margin-right: 8px;margin-top: -3px; margin-left: 5px;')) }}</a></li>
              @endforeach
              </ul>
            </li>
          @endif
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
          <!-- Authentication Links -->
          <li><a href="{{url('contact')}}">Contacto</a></li>
          @if (!Auth::guest())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Salir</a></li>
              </ul>
            </li>
          @else
            <li>
              <a href="{{ url('/login') }}">Login</span>
              </a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>

  <div class="clearfix" style="margin-top: 90px;"><br/></div>

  @yield('content')



  <div class="clearfix"><br/></div>
  <div class="container">
    <hr>
    <h6 class="small">&copy; 2017 - <a href="https://github.com/raudiez" target="_blank">Raúl Díez Sánchez</a> - Read <a href="{{ url('/disclaimer') }}">disclaimer</a> for legal and abuse related information.</h6>
  </div>
  <!-- JavaScripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $( ".dropdown-submenu" ).click(function(event) {
          // stop bootstrap.js to hide the parents
          event.stopPropagation();
          // hide the open children
          $( this ).find(".dropdown-submenu").removeClass('open');
          // add 'open' class to all parents with class 'dropdown-submenu'
          $( this ).parents(".dropdown-submenu").addClass('open');
          // this is also open (or was)
          $( this ).toggleClass('open');
      });
    });
  </script>
  <script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover(); 
    });
  </script>

</body>
</html>
