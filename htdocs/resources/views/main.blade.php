@extends('layout')

@section('title', $title)

@section('styles')
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @if ($oSlides)
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($oSlides as $oSlide)
                    <div class="swiper-slide">
                        <img style="height: 300px;" src="{{ asset('img') . '/' . config('settings.user.slider_image_dir') . '/' . $oSlide->img }}" title="{{ $oSlide->text }}" />
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    @endif

    <h1>{{ $headline }}</h1>
    {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'onsubmit' => 'articleFilter(); return false;']) !!}
        <div class="col-sm-3">
            {{ Lang::get('main.label_name') }}: {!! Form::text('name', '', ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-3">
            {{ Lang::get('main.label_category') }}: {!! Form::select('group_id', ['0' => '-'] + $aArtGr, '', ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-3">
            {{ Lang::get('main.label_from') }}: {!! Form::text('dateFrom', '', ['class' => 'form-control datepickerBS']) !!}
            {{ Lang::get('main.label_to') }}: {!! Form::text('dateTo', '', ['class' => 'form-control datepickerBS']) !!}
        </div>

        <div class="col-sm-3">
            <br />
            {!! Form::submit( Lang::get('main.btn_find'), ['class' => 'btn btn-success']) !!}
        </div>
    {!! Form::close() !!}
    <div class="clear" style=""></div>
    <br />
    <div id="articleContainer">
        @foreach ($articles as $article)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    {{ $article->title }}, {{ $article->created_at->format('Y/m/d') }}
                </div>
                <div class="panel-body">
                    <p>
                        {{ $article->text }}
                    </p>
                    {!! HTML::link(route('articles.show', $article->id), Lang::get('main.articles.read_more')) !!}
                </div>
            </div>
        @endforeach
        {!! $articles->render() !!}
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/swiper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
@endsection