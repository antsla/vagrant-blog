@if (Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{  Lang::get('admin/layout.headline_errors') }}</strong><br />
        {!! implode('<br />', $errors->all()) !!}
    </div>
@endif