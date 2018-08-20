<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Insular</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{asset('css/fixedHeader.dataTables.min.css')}}" rel="stylesheet" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->

    <link href="{{ asset('css/material-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <title>
      Insular
    </title>

</head>

<body class="">
  <div class="wrapper ">
  @guest
  @else
    <div class="sidebar" data-color="orange" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
      <div class="logo">
        <a class="simple-text logo-normal">
          Insular
        </a>
      </div>
      <div class="sidebar-wrapper sidebar_background div-wrapper" >
        <ul class="nav">
          @if(  app('request')->input('v') == '1' )

            <li class="nav-item active  " >
              <a class="nav-link" href="{{ url('home/?v=1') }}" style="background-color:#191970; box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgb(89, 100, 150);">
                <i class="material-icons">dashboard</i>
                <p> Inicio</p>
              </a>
            </li>

          @else

            <li class="nav-item ">
              <a class="nav-link" href="{{ url('home/?v=1') }}"  >
                <i class="material-icons " style="color:white;">dashboard</i>
                <p class="sidebar_text_unselected"> Inicio</p>
              </a>
            </li>

          @endif


          @if(  app('request')->input('v') == '2' )
            <li class="nav-item  active">
              <a class="nav-link" href="{{ url('users/?v=2') }}"  style="background-color:#191970; box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgb(89, 100, 150);">
                <i class="material-icons" style="color:white;">person</i>
                <p class="sidebar_text_unselected">Usuarios</p>
              </a>
            </li>
          @else
            <li class="nav-item ">
              <a class="nav-link" href="{{ url('users/?v=2') }}">
                <i class="material-icons" style="color:white;">person</i>
                <p class="sidebar_text_unselected">Usuarios</p>
              </a>
            </li>
          @endif

          @if(  app('request')->input('v') == '3' )
            <li class="nav-item active ">
              <a class="nav-link " href="{{ url('transactions/?v=3') }}"  style="background-color:#191970; box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgb(89, 100, 150);">
                <i class="material-icons"  style="color:white;">content_paste</i>
                <p class="sidebar_text_unselected">Transacciones</p>
              </a>
            </li>
          @else
            <li class="nav-item ">
              <a class="nav-link" href="{{ url('transactions/?v=3') }}">
                <i class="material-icons"  style="color:white;">content_paste</i>
                <p class="sidebar_text_unselected">Transacciones</p>
              </a>
            </li>
          @endif

          @if(  app('request')->input('v') == '4' )
            <li class="nav-item active">
              <a class="nav-link" href="{{url('wallet_transaction/getAll/?v=4')}}"  style="background-color:#191970; box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgb(89, 100, 150);">
                <i class="material-icons"  style="color:white;">library_books</i>
                <p class="sidebar_text_unselected"> Movimientos de cuenta</p>
              </a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{url('wallet_transaction/getAll/?v=4')}}">
                <i class="material-icons"  style="color:white;">library_books</i>
                <p class="sidebar_text_unselected"> Movimientos de cuenta</p>
              </a>
            </li>
          @endif

          @if(  app('request')->input('v') == '5' )
            <li class="nav-item active">
              <a class="nav-link" href="{{ url('exchange_rates/?v=5') }}"  style="background-color:#191970; box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgb(89, 100, 150);">
                <i class="material-icons"  style="color:white;">bubble_chart</i>
                <p class="sidebar_text_unselected">Tasas de cambio</p>
              </a>
            </li>
          @else
            <li class="nav-item ">
              <a class="nav-link" href="{{ url('exchange_rates/?v=5') }}">
                <i class="material-icons"  style="color:white;">bubble_chart</i>
                <p class="sidebar_text_unselected">Tasas de cambio</p>
              </a>
            </li>
          @endif

        </ul>
        <img src="{{url('img/logo_white.png')}}"/>
      </div>
    </div>
  @endguest
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>

      </nav>

      <!-- End Navbar -->
      <div class="content">


        <main class="py-4">
            @yield('content')
        </main>

      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            <ul>

            </ul>
          </nav>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, Insular.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->


</body>
</html>
