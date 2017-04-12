<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- // Start SEO -->
    <title>{{ $page->getSeoTitle() }}</title>
    <meta name="description" content="{{ $page->getSeoDescription() }}"/>

    {{--<link rel="canonical" href="{{ $content->getCanonical() }}"/>--}}

    <!-- Open Graph data -->
    {{--<meta property="og:title" content="{{ $content->getSeo('og_title') }}" />--}}
    {{--<meta property="og:type" content="website" />--}}
    {{--<meta property="og:url" content="{{ Request::url() }}" />--}}
    {{--<meta property="og:description" content="{{ $content->getSeo('og_description') }}" />--}}
    {{--@if($image = $content->getImagePath(['w' => 400]))--}}
    {{--<meta property="og:image" content="{!! $image !!}" />--}}
    {{--@endif--}}

            {{--<!-- Twitter Card data -->--}}
    {{--<meta name="twitter:card" content="summary">--}}
    {{--<meta name="twitter:site" content="{{ '@' . $content->getSeo('twitter_site') }}">--}}
    {{--<meta name="twitter:title" content="{{ $content->getSeo('twitter_title') }}">--}}
    {{--<meta name="twitter:description" content="{{ $content->getSeo('twitter_description') }}">--}}
    {{--<meta name="twitter:creator" content="{{ '@' . $content->getSeo('twitter_creator') }}">--}}
    {{--@if($image = $content->getImagePath(['w' => 400]))--}}
        {{--<meta name="twitter:image" content="{!! $image !!}" />--}}
    {{--@endif--}}
    {{--<meta name="twitter:url" content="{{ Request::url() }}" />--}}

    {{--<!-- Google+ -->--}}
    {{--<link href="{{ $content->getSeo('google_plus_publisher') }}" rel="publisher" />--}}
    {{--<link href="{{ $content->getSeo('google_plus_author') }}" rel="author" />--}}
    <!-- End SEO // -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ theme('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ site('name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    {!! nav('main', 'nav navbar-nav') !!}


                </div>
            </div>
        </nav>

        @yield('content')

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        {!! nav('footer', 'list-unstyled') !!}
                    </div>

                    <div class="col-md-4">
                        <p></p>
                    </div>

                    <div class="col-md-4">
                        <p>&copy; {{ site('name') }} {{ date('Y') }}</p>

                        <ul>
                            @foreach(get_nav('social')->items as $item)
                            <li>
                                <a href="{{ $item->external_link }}" target="_blank">{{ $item->label }}</a>

                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-md-offset-4 text-center">Powered by <a href="https://www.iseekplant.com.au" target="_blank">iSeekplant</a></div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ theme('js/app.js') }}"></script>
</body>
</html>
