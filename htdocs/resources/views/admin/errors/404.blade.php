@extends('admin.layout')

@section('title', Lang::get('admin/layout.title_404'))

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <h1> Oops!</h1>
            <h2>404 <br /> {{ Lang::get('admin/layout.not_found') }} </h2>
            {!! HTML::link(URL::previous(), Lang::get('admin/layout.error_back')) !!}
        </div>
    </div>
@endsection