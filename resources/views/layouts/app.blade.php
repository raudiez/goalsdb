<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FifaGoalsDB</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        .fa-btn {
            margin-right: 6px;
        }
        .table-hover > tbody > tr:hover {
          background-color: #C0C2CD;
        }

    </style>
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
                <a class="navbar-brand" href="{{ url('/') }}">
                    FifaGoalsDB
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (!Auth::guest())
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clubs <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="{{url('/teams')}}">Todos</a></li>
                            <li role="separator" class="divider"></li>
                            @foreach ($teams as $team_link)
                                <li><a href="{{url('/teams/show/'.$team_link->id)}}">
                                {{ Html::image('imgs/teams/'.$team_link->logo.'.png','',array('style' => 'height: 12px; margin-right: 8px;margin-top: -3px; margin-left: 0px;')) }}
                                {{$team_link->name}}</a></li>
                            @endforeach
                          </ul>
                        </li>
                    @endif
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Salir</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="clearfix" style="margin-top: 60px;"><br/></div>

    @yield('content')



    <div class="clearfix"><br/></div>
    <div class="container">
        <hr>
        <h6 class="small">&copy; 2016 - <a href="https://github.com/raudiez">Raúl Díez Sánchez</a></h6>
    </div>
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{URL::asset('js/jquery.bootstrap-dropdown-hover.min.js')}}"></script>
    <script>
        $('.navbar [data-toggle="dropdown"]').bootstrapDropdownHover({});
    </script>



</body>
</html>
