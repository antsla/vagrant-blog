@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h3>{{ Lang::get('admin/articles_categories.headline_index') }}</h3>
    @include('includes/_errors_place')
    <table class="table">
        <tr>
            <th>#</th>
            <th>{{ Lang::get('admin/articles_categories.th_name') }}</th>
            <th>{{ Lang::get('admin/articles_categories.th_action') }}</th>
        </tr>
        @foreach ($oArticleCategories as $oArticleCategory)
            <tr>
                <td>{{ $oArticleCategory->id }}</td>
                <td>{!! $oArticleCategory->level !== '1'?str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $oArticleCategory->level - 1).'<img src="/img-service/enter-arrow.svg" class="enter-arrow" />':'' !!} {{ $oArticleCategory->title }}</td>
                <td>
                    {!! HTML::link(route('admin::articles_categories.edit', $oArticleCategory->id), Lang::get('admin/articles_categories.btn_edit'), ['class' => 'btn btn-success']) !!}
                    {!! Form::open(['method' => 'post', 'url' => route('admin::articles_categories.delete', $oArticleCategory->id), 'style' => 'display: inline-block']) !!}
                    {!! Form::token() !!}
                    {!! method_field('DELETE') !!}
                    {!! Form::submit(Lang::get('admin/articles_categories.btn_delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirm("' . Lang::get('admin/articles_categories.confirm_del') . '");']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">
                {!! HTML::link(route('admin::articles_categories.create'), Lang::get('admin/articles_categories.btn_create'), ['class' => 'btn btn-primary']) !!}
            </td>
        </tr>
    </table>
@endsection