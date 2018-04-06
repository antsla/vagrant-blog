<div class="modal fade" id="modal-comment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentTitle"></h5>
            </div>
            {!! Form::open(['url' => '/updateCommentAjax', 'method' => 'post', 'onsubmit' => 'updateComment(); return false;']) !!}
            <div class="commentText">
                {!! Form::textarea('editComment', '', ['class' => 'form-control', 'id' => 'editComment']) !!}
                {!! Form::hidden('editCommentId', '', ['id' => 'editCommentId']) !!}
            </div>
            <div class="modal-footer">
                {!! Form::button(Lang::get('articles.btn_modal_close'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                {!! Form::submit(Lang::get('articles.btn_modal_save'), ['class' => 'btn btn-primary']) !!}
            </div>
            {{ method_field('PUT') }}
            {!! Form::close() !!}
        </div>
    </div>
</div>