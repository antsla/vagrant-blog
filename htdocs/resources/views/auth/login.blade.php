@extends('layout')

@section('title', $aMeta['title'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">

                    <div class="panel-heading">{!! $sHeadline !!}</div>

                    <div class="panel-body">

                        {!! Form::open(['method' => 'POST', 'action' => 'Auth\LoginController@login', 'class' => 'form-horizontal']) !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('email', Lang::get('auth.label_email'), ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {!! Form::label('password', Lang::get('auth.label_password'), ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox('remember', old('remember') ? 'checked' : '') !!} {!! Lang::get('auth.chkb_remember') !!}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    {!! Form::submit(Lang::get('auth.btn_login'), ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection