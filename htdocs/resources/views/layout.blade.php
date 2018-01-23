<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!--<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {!! HTML::link(route('MainPage'), 'BlankApp', ['class' => 'navbar-brand']) !!}
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        {!! HTML::link(route('feedback.index'), Lang::get('layout.menu_feedback')) !!}
                    </li>
                    @if (Auth::check())
                        <li>
                            {!! HTML::link(route('admin::articles.index'), Lang::get('layout.come_in')) !!}
                        </li>
                        <li>
                            {!! HTML::link(route('auth.logout'), Lang::get('layout.log_out')) !!}
                        </li>
                    @else
                        <li class="{{ Request::url() == route('auth.register') ? 'active' : '' }}">
                            {!! HTML::link(route('auth.register'), Lang::get('layout.registration')) !!}
                        </li>
                        <li class="{{ Request::url() == route('auth.login') ? 'active' : '' }}">
                            {!! HTML::link(route('auth.login'), Lang::get('layout.authorization')) !!}
                        </li>
                    @endif
                    <li class="{{ Cookie::get('locale') === 'ru' ? 'active' : '' }}">
                        {!! HTML::link(route('setLocale', 'ru'), 'ru') !!}
                    </li>
                    <li class="{{ Cookie::get('locale') === 'en' ? 'active' : '' }}">
                        {!! HTML::link(route('setLocale', 'en'), 'en') !!}
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            @yield('breadcrumbs')
            @yield('content')
         </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <!--<script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>-->
    <!--<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>-->
    <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
    @yield('scripts')
</body>
</html>