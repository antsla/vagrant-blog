@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h2>{{ Lang::get('admin/articles.headline_index') }}</h2>
    @include('includes/_errors_place')
    <table class="table">
        <tr>
            <th>#</th>
            <th>{{ Lang::get('admin/articles.th_name') }}</th>
            <th>{{ Lang::get('admin/articles.th_text') }}</th>
            <th>{{ Lang::get('admin/articles.th_group') }}</th>
            <th>{{ Lang::get('admin/articles.th_action') }}</th>
        </tr>
        @foreach ($oArticles as $oArticle)
            <tr>
                <td>{{  $oArticle->id }}</td>
                <td>{{  $oArticle->title }}</td>
                <td>{{  str_limit($oArticle->text, 15) }}</td>
                <td>{{  $oArticle->group ? $oArticle->group->title : '-' }}</td>
                @if (Auth::check())
                <td>
                    <a href="{{ route('admin::articles.edit', $oArticle->id) }}" class="btn btn-primary">{{ Lang::get('admin/articles.btn_edit') }}</a>
                    {!! Form::open(['method' => 'post', 'url' => route('admin::articles.delete', $oArticle->id), 'style' => 'display: inline-block;']) !!}
                    {!! Form::token() !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::submit(Lang::get('admin/articles.btn_delete'), array('class' => 'btn btn-danger', 'onclick' => 'return confirm("' . Lang::get('admin/articles.confirm_del') . '");')) !!}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
        @endforeach
        {!! $oArticles->render() !!}
        <tr>
            <td colspan="4">
                {!! HTML::link(route('admin::articles.create'), Lang::get('admin/articles.btn_create'), ['class' => 'btn btn-primary']) !!}
            </td>
        </tr>
    </table>
@endsection
