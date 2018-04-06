@extends('admin.layout')

@section('title', Lang::get('admin/layout.title_banned'))

@section('content')
    <div class="col-md-12">
        <div class="text-center">
            <h1> Oops!</h1>
            <h2>{{ Lang::get('admin/layout.banned') }}</h2>
        </div>
    </div>
@endsection