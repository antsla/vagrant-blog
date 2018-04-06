@if (Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>{!! implode('<br />', $errors->all()) !!}</strong>
    </div>
@endif