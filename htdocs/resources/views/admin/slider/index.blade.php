@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h1>{{ Lang::get('admin/slider.headline_index') }}</h1>
    @include('includes/_errors_place')
    @if ($oSlides)
        <div id="slider-edit-block">
            @include('admin.slider._slides_table')
        </div>
    @endif
@endsection