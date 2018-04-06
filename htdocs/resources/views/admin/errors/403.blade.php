@extends('admin.layout')

@section('title', Lang::get('admin/layout.title_403'))

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <h1> Oops!</h1>
            <h2>403 <br /> {{ Lang::get('admin/layout.perm_denied') }}</h2>
            {!! HTML::link(URL::previous(), Lang::get('admin/layout.error_back')) !!}
        </div>
    </div>
@endsection