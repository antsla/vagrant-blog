@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs, $sTableName))

@section('content')
    <h1>{{ Lang::get('admin/parsing.show_headline') }}</h1>

    <table class="table">
        <tr>
            @foreach($heading as $head)
                <th>{{ $head }}</th>
            @endforeach
            <th>{{ Lang::get('admin/parsing.th_action') }}</th>
        </tr>
        @foreach ($items as $item)
            <tr>
                @foreach ($item as $fields)
                    <td>{{ $fields }}</td>
                @endforeach
                <td>
                    -
                </td>
            </tr>
        @endforeach
    </table>

@endsection