<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Backend</title>

    <base href="../">
    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    <!-- Custom styles -->
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
    <script src="{{asset('assets/Chart.min.js')}}"></script>

        <link href="{{asset('public/assets/css/bootstrap.css')}}" rel="stylesheet">
        <!-- Custom styles -->
        <link href="{{asset('public/assets/css/custom.css')}}" rel="stylesheet">
        <script src="{{asset('public/assets/Chart.min.js')}}"></script>
</head>

<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{route('events.index')}}">Event Platform</a>
    <span class="navbar-organizer w-100">{{Auth::user()->name}}</span>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" id="logout" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                Sign out
            </a>

            <form method="post" id="logout-form" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        @yield('content')
    </div>
</div>

</body>
</html>
