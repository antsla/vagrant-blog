@extends('layout')

@section('title', 'Страница не найдена')

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <h1> Oops!</h1>
            <h2>404 Not Found</h2>
            {!! HTML::link(URL::previous(), Lang::get('layout.error_back')) !!}
            <div class="error-details">
                {{ Lang::get('layout.404_text') }}
            </div>
        </div>
    </div>
@endsection