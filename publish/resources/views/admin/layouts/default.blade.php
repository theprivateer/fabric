<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @section('head')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fabric') }}</title>

    <!-- Styles -->
    <link href="/vendor/fabric/css/admin.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @show
</head>
<body>
<div id="app">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route('fabric::home') }}">
                    {{ site('name') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Back to Site</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Welcome, {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">

                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if(Auth::check())
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas sidebar" id="sidebar">
            <ul class="sidenav">
                <li class="dropdown _active">
                    <a href="#" data-toggle="dropdown">
                        Site
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('fabric::site.edit') }}">Settings</a></li>
                        <li><a href="{{ route('fabric::domain.index') }}">Domains</a></li>
                        <li><a href="{{ route('fabric::redirect.index') }}">Redirects</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">
                        Pages
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('fabric::page.index') }}">All Pages</a></li>
                        <li><a href="{{ route('fabric::page.create') }}">Create Page</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">
                        Articles
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('fabric::article.index') }}">All Articles</a></li>
                        <li><a href="{{ route('fabric::article.create') }}">Create Article</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('fabric::index.index') }}">
                        Indices
                    </a>
                </li>
            </ul>
        </div>

        <div class="page-body content-offcanvas">
            <div class="container-fluid">
                @include('flash::message')

                @yield('content')
            </div>
        </div>
    </div>
    @else
    <div class="container">
        @yield('content')
    </div>
    @endif
</div>

@section('scripts')
<!-- Scripts -->
<script src="/vendor/fabric/js/app.js"></script>
@show
</body>
</html>
