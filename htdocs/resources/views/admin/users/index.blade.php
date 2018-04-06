@extends('admin.layout')

@section('title', $sTitle)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs))

@section('content')
    <h1>{{ Lang::get('admin/users.headline_index') }}</h1>
    @include('includes/_errors_place')
    @if ($oUsers)
        <table class="table">
            <tr>
                <th>#</th>
                <th>{{ Lang::get('admin/users.th_name') }}</th>
                <th>{{ Lang::get('admin/users.th_email') }}</th>
                <th>{{ Lang::get('admin/users.th_created') }}</th>
                <th>{{ Lang::get('admin/users.th_rights') }}</th>
                <th></th>
            </tr>
            @foreach($oUsers as $oUser)
                <tr style="{{ (Auth::id() == $oUser->id) ? 'background-color: #dff0d8;' : '' }} {{ ($oUser->flag_banned === '1') ? 'background-color:#f2dede;' : '' }}">
                    <td>{{ $oUser->id }}</td>
                    <td>{{ $oUser->name }}</td>
                    <td>{{ $oUser->email }}</td>
                    <td>{{ $oUser->created_at->format('d.m.Y') }}</td>
                    <td>{{ $oUser->role->name }}</td>
                    <td>
                        @if (Auth::id() != $oUser->id)
                            {!! Form::open(['url' => route('admin::users.change_status', ['id' => $oUser->id, 'type' => $oUser->flag_banned ? 'unban' : 'ban']), 'method' => 'post']) !!}
                                {{ method_field('PUT') }}
                                {!! Form::submit(($oUser->flag_banned ? Lang::get('admin/users.btn_unban'):Lang::get('admin/users.btn_ban')),
                                    ['class' => 'btn ' . ($oUser->flag_banned ? 'btn-success' : 'btn-warning')]) !!}
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection