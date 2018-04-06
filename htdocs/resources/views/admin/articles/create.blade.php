@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h3>{{ Lang::get('admin/articles.headline_create') }}</h3>
    @include('includes/_errors_place')
    {!! Form::open(['url' => route('admin::articles.save'), 'class' => 'form-horizontal', 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('a_name', Lang::get('admin/articles.label_name'), array('class' => 'control-label col-sm-2')) !!}
        <div class="col-sm-10">
            {!! Form::text('a_name', old('a_name'), array('class' => 'form-control', 'id' => 'a_name', 'placeholder' => Lang::get('admin/articles.ph_name'))) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('a_text', Lang::get('admin/articles.label_text'), array('class' => 'control-label col-sm-2')) !!}
        <div class="col-sm-10">
            {!! Form::textarea('a_text', old('a_text'), array('class' => 'form-control', 'id' => 'a_text', 'placeholder' => Lang::get('admin/articles.ph_text'))) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('a_group_id', Lang::get('admin/articles.label_group'), array('class' => 'control-label col-sm-2')) !!}
        <div class="col-sm-10">
            {!! Form::select('a_group_id', $aArticlesCategories, old('a_group_id'), array('class' => 'form-control', 'id' => 'a_group_id')) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit(Lang::get('admin/articles.btn_save'), array('class' => 'btn btn-success')) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
