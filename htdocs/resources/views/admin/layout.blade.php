<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', $sTitle)</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/spacing.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/admin/styles.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
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
            <a class="navbar-brand" href="{{ route('admin::index') }}">{{ Lang::get('admin/layout.logoname') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::url() == route('admin::articles_categories.index') ? 'active' : '' }}">
                    {!! HTML::link(route('admin::articles_categories.index'), Lang::get('admin/layout.articles_categories')) !!}
                </li>
                <li class="{{ Request::url() == route('admin::articles.index') ? 'active' : '' }}">
                    {!! HTML::link(route('admin::articles.index'), Lang::get('admin/layout.articles')) !!}
                </li>
                <li class="{{ Request::url() == route('admin::slider.index') ? 'active' : '' }}">
                    {!! HTML::link(route('admin::slider.index'), Lang::get('admin/layout.slider')) !!}
                </li>
                <li class="{{ Request::url() == route('admin::settings.index') ? 'active' : '' }}">
                    {!! HTML::link(route('admin::settings.index'), Lang::get('admin/layout.settings')) !!}
                </li>
                <li class="{{ Request::url() == route('admin::parsing.index') ? 'active' : '' }}">
                    {!! HTML::link(route('admin::parsing.index'), Lang::get('admin/layout.parsing')) !!}
                </li>
                <li class="{{ Request::url() == route('admin::users.index') ? 'active' : '' }}">
                    {!! HTML::link(route('admin::users.index'), Lang::get('admin/layout.users')) !!}
                </li>
                <li class="{{ Request::url() == route('admin::feedback.index') ? 'active' : '' }}">
                    {!! HTML::link(route('admin::feedback.index'), Lang::get('admin/layout.feedback')) !!}
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    {!! HTML::link(route('MainPage'), Lang::get('admin/layout.back_to_site')) !!}
                </li>
                <li>
                    {!! HTML::link(route('auth.logout'), Lang::get('admin/layout.logout')) !!}
                </li>
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
<script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/bootstrap-file.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/functions.js') }}"></script>
@yield('scripts')
</body>
</html>