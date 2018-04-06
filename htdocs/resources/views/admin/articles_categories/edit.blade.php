@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs, $oArticlesCategory->title))

@section('content')
    <h3>{{ Lang::get('admin/articles_categories.headline_edit') }}</h3>
    @include('includes/_errors_place')
    {!! Form::open(['url' => route('admin::articles_categories.update', $oArticlesCategory->id), 'method' => 'post', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
        {!! Form::label('ac_name', Lang::get('admin/articles_categories.label_name'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::text('ac_name', old('ac_name', $oArticlesCategory->title), ['class' => 'form-control', 'id' => 'ac_name', 'placeholder' => Lang::get('admin/articles_categories.ph_name')]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('ac_parent_id', Lang::get('admin/articles_categories.label_parent'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::select('ac_parent_id', $aArticlesCategories, old('ac_parent_id', $oArticlesCategory->parent_id), ['id' => 'ac_parent_id', 'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit(Lang::get('admin/articles_categories.btn_save'), ['class' => 'btn btn-success']) !!}
        </div>
    </div>
    {{ method_field('PUT') }}
    {!! Form::close() !!}
@endsection