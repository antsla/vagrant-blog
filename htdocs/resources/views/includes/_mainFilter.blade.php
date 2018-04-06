@foreach ($oArticles as $oArticle)
    <div class="panel panel-primary">
        <div class="panel-heading">
            {{ $oArticle->title }}, {{ $oArticle->created_at->format('Y/m/d') }}
        </div>
        <div class="panel-body">
            <p>
                {{ $oArticle->text }}
            </p>
            {!! HTML::link(route('articles.show', $oArticle->id), Lang::get('main.read_more')) !!}
        </div>
    </div>
@endforeach