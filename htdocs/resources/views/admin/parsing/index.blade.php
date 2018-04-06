@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h1>{{ Lang::get('admin/parsing.index_headline') }}</h1>

    @include('includes/_errors_place')

    {!! Form::open(['url' => route('admin::parsing.result'), 'files' => true, 'class' => 'form-horizontal', 'method' => 'post']) !!}
        {!! Form::file('file', ['title' => Lang::get('admin/parsing.btn_choose')]) !!}
        <br />
        {!! Form::submit(Lang::get('admin/parsing.btn_save'), ['class' => 'm-t btn btn-success']) !!}
    {!! Form::close() !!}
    <h2>{{ Lang::get('admin/parsing.headline_processed_files') }}</h2>

    <table class="table">
        <tr>
            <th>#</th>
            <th>{{ Lang::get('admin/parsing.th_name') }}</th>
            <th>{{ Lang::get('admin/parsing.th_uploaded') }}</th>
            <th>{{ Lang::get('admin/parsing.th_action') }}</th>
        </tr>
        @if (isset($oTables))
            @foreach ($oTables as $oTable)
                <tr>
                    <td>{{ $oTable->id }}</td>
                    <td><a href="{{ route('admin::parsing.show', $oTable->id ) }}">{{ $oTable->postfix }}</a></td>
                    <td>{{ $oTable->created_at }}</td>
                    <td>
                        {!! Form::open(['method' => 'post', 'url' => route('admin::parsing.delete', $oTable->id)]) !!}
                        {!! Form::token() !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::submit(Lang::get('admin/parsing.btn_delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirm(" ' . Lang::get('admin/parsing.delete_confirm') . '");']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

@endsection