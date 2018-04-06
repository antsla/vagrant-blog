@extends('layout')

@section('title', $aMeta['title'])

@section('content')
    <h1>{{ $sHeadline }}</h1>

    {!! Form::open(['method' => 'post', 'class' => 'form-horizontal']) !!}
        <div class="col-sm-12 m-b-xs">
            {!! Form::label('fb_name', Lang::get('feedback.label_name'), ['class' => 'control-label']) !!}
            {!! Form::text('fb_name', '', ['class' => 'form-control', 'id' => 'fb_name', 'placeholder' => Lang::get('feedback.ph_name')]) !!}
        </div>
        <div class="col-sm-12 m-b-xs">
            {!! Form::label('fb_email', Lang::get('feedback.label_email'), ['class' => 'control-label']) !!}
            {!! Form::text('fb_email', '', ['class' => 'form-control', 'id' => 'fb_email', 'placeholder' => Lang::get('feedback.ph_email')]) !!}
        </div>
        <div class="col-sm-12 m-b-sm">
            {!! Form::label('fb_text', Lang::get('feedback.label_text'), ['class' => 'control-label']) !!}
            {!! Form::textarea('fb_text', '', ['class' => 'form-control', 'id' => 'fb_text']) !!}
        </div>
        <div class="col-sm-12">
            {!! Form::submit(Lang::get('feedback.btn_send'), ['class' => 'btn btn-success', 'id' => 'fb_submit']) !!}
        </div>
    {!! Form::close() !!}
@endsection