@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h1>{{ Lang::get('admin/feedback.headline_show') }}</h1>
    <div>
        <p>
            <em>{{ $oReview->created_at->format('Y/m/d H:i:s') }}</em>,
            <strong>{{ $oReview->name }}</strong>
            {{ Lang::get('admin/feedback.write_on') }}:
        </p>
        <p>
            {{ $oReview->text }}
        </p>
    </div>
    @include('includes/_errors_place')
    <h3>{{ Lang::get('admin/feedback.headline_response') }}</h3>
    {!! Form::open(['url' => route('admin::feedback.response_to_user', $oReview->id), 'method' => 'post']) !!}
        {!! Form::textarea('fb_response_text', old('fb_response_text'), ['class' => 'form-control', 'placeholder' => Lang::get('admin/feedback.ph_response_text')]) !!}
        {!! Form::submit(Lang::get('admin/feedback.btn_send'), ['class' => 'btn btn-success m-t']) !!}
    {!! Form::close() !!}
@endsection