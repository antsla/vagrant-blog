<table class="table slider-edit-table">
    <tr>
        <th>#</th>
        <th>{{ Lang::get('admin/slider.th_photo') }}</th>
        <th>{{ Lang::get('admin/slider.th_desc') }}</th>
        <th colspan="2">{{ Lang::get('admin/slider.th_order') }}</th>
        <th></th>
    </tr>
    @foreach($oSlides as $oSlide)
        <tr>
            <td>{{ $oSlide->id }}</td>
            <td><img src="{{ asset('img') . '/' . config('settings.user.slider_image_dir') . '/thumb/' . $oSlide->img }}" /></td>
            <td>{{ $oSlide->text }}</td>
            <td>
                <div>{{ $oSlide->sort }}</div>
            </td>
            <td class="sort-slider-actions">
                @if ($loop->iteration != 1)
                    <span onclick="orderToUp({{ $oSlide->id }});"><i class="glyphicon glyphicon-arrow-up"></i></span>
                @endif
                @if ($loop->iteration != $loop->count)
                    <span onclick="orderToDown({{ $oSlide->id }});"><i class="glyphicon glyphicon-arrow-down"></i></span>
                @endif
            </td>
            <td>
                {!! HTML::link(route('admin::slider.edit', $oSlide->id), Lang::get('admin/slider.btn_edit'), ['class' => 'btn btn-primary']) !!}

                {!! Form::open(['url' => route('admin::slider.delete', $oSlide->id), 'method' => 'POST']) !!}
                {{ method_field('DELETE') }}
                {!! Form::submit(Lang::get('admin/slider.btn_delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirm("' . Lang::get('admin/slider.confirm_del') . '");']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="5">
            {!! HTML::link(route('admin::slider.create'), Lang::get('admin/slider.btn_create'), ['class' => 'btn btn-primary']) !!}
        </td>
    </tr>
</table>