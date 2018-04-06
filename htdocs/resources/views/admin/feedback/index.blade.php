@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h1>{{ Lang::get('admin/feedback.headline_index') }}</h1>
    @if(!$oFeedback->isEmpty())
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ Lang::get('admin/feedback.th_name') }}</th>
                <th>{{ Lang::get('admin/feedback.th_email') }}</th>
                <th>{{ Lang::get('admin/feedback.th_date') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($oFeedback as $oReview)
                <tr>
                    <td>{{ $oReview->id }}</td>
                    <td>{!! HTML::link(route('admin::feedback.show', $oReview->id), $oReview->name) !!}</td>
                    <td>{{ $oReview->email }}</td>
                    <td>{{ $oReview->created_at->format('Y/m/d H:i:s') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection