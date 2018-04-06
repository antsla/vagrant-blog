@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h1>{{ Lang::get('admin/slider.headline_edit') }}</h1>
    @include('includes/_errors_place')
    {!! Form::open(['url' => route('admin::slider.update', $oSlide->id), 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal']) !!}
    <div class="form-group">
        {!! Form::label('sl_text', Lang::get('admin/slider.label_text'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::textarea('sl_text', $oSlide->text, ['class' => 'form-control', 'id' => 'sl_text', 'placeholder' => Lang::get('admin/slider.ph_text')]) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <img src="{{ asset('img') . '/' . config('settings.user.slider_image_dir') . '/thumb/' . $oSlide->img }}" />
            <br /><br />
            {!! Form::file('sl_img', ['title' => Lang::get('admin/slider.label_chg_img')]) !!}
        </div>
    </div>
    {!! method_field('PUT') !!}
    <div class="col-sm-offset-2">
        {!! Form::submit(Lang::get('admin/slider.btn_save'), ['class' => 'btn btn-success']) !!}
    </div>
    {!! Form::close() !!}
@endsection