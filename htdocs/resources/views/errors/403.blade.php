@extends('layout')

@section('title', 'Страница не найдена')

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <h1> Oops!</h1>
            <h2>403 Permisiion denied</h2>
            {!! HTML::link(URL::previous(), Lang::get('layout.error_back')) !!}
        </div>
    </div>
@endsection