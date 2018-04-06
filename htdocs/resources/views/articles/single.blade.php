@extends('layout')

@section('title', $oArticle->title)

@section('breadcrumbs', Breadcrumbs::render($sBreadcrumbs, $oArticle->title))

@section('content')
    <h2>{{ $oArticle->title }}</h2>
    <p>
        {{ $oArticle->text }}
    </p>
    <hr />
    <div class="media">
        @include('includes/_messages_comments')
        @foreach ($oArticle->comments as $oComment)
            <div class="media-body" style="padding-left: {!! $oComment->level !== '1' ? (40 * ($oComment->level - 1)) . 'px;' : '' !!}">
                @if ($oComment->deleted_at === null)
                    @can('changeArticle', $oArticle)
                        {!! Form::open(['url' => route('articles.comments.delete', $oComment->id), 'method' => 'post']) !!}
                        {!! Form::submit('x', ['class' => 'close']) !!}
                        {!! method_field('DELETE') !!}
                        {!! Form::close() !!}
                    @endcan
                    <h4 class="media-heading">{{ $oComment->username . ', ' . $oComment->created_at }}</h4>
                    <div class="comment-block" id="data-comment-<?= $oComment->id?>">
                        {{ $oComment->text }}
                    </div>
                    <div class="response-link" data-comment-id="<?= $oComment->id?>">{{ Lang::get('articles.btn_response') }}</div>
                    @can('changeArticle', $oArticle)
                        <div class="edit-link" data-comment-id="<?= $oComment->id?>" id="test-<?= $oComment->id?>">{{ Lang::get('articles.btn_edit') }}</div>
                    @endcan
                @else
                    {{ Lang::get('articles.info_deleted') }}
                    @can('changeArticle', $oArticle)
                        <a class="restore-link">
                            {!! Form::open(['url' => route('articles.comments.restore', $oComment->id), 'method' => 'post']) !!}
                            {!! Form::submit(Lang::get('articles.btn_restore'), ['class' => 'btn btn-link']) !!}
                            {!! method_field('PUT') !!}
                            {!! Form::close() !!}
                        </a>
                    @endcan
                @endif
            </div>
            <br />
        @endforeach

    </div>
    <h4 id="#addComment">{{ Lang::get('articles.headline_add') }}</h4>
    <hr />

    {!! Form::open(['url' => route('articles.save_comment', $oArticle->id), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'response_form']) !!}
    <div class="form-group">
        {!! Form::text('name', old('name'), array('class' => 'form-control', 'placeholder' => Lang::get('articles.ph_name'))) !!}
    </div>
    <div class="form-group">
        {!! Form::textarea('text', old('text'), ['class' => 'form-control', 'placeholder' => Lang::get('articles.ph_text')]) !!}
    </div>
    {!! Form::hidden('response_id', '0') !!}
    <div class="form-group">
        {!! Form::submit(Lang::get('articles.btn_add'), array('class' => 'btn btn-success')) !!}
    </div>
    {!! Form::close() !!}

    @include('includes/_modal_comment')

@endsection
