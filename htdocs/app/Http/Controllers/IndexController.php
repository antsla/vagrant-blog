<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Slider;

class IndexController extends SiteController
{
    public function index()
    {
        //dd();
        $sTitle = Lang::get('main.title');
        $oUser = Auth::user();
        $sHeadline = Lang::get('main.headline', ['name' => $oUser !== null ? $oUser->name : Lang::get('main.default_name')]);
        return view('main', [
                'articles' => Article::orderBy('created_at', 'desc')->paginate(5),
                'aArtGr' => ArticleCategory::select(DB::raw('CONCAT (REPEAT(" -> ", level - 1), title) as name'), 'id')->orderBy('path')->get()->pluck('name', 'id')->toArray(),
                'oSlides' => Slider::select('img', 'text')->orderBy('sort')->get(),
                'title' => $sTitle,
                'headline' => $sHeadline
            ]
        );
    }

    public function getFilterArticlesAjax()
    {
        $oArticles = Article::orderBy('created_at', 'desc');

        if (!empty($_GET['name'])) {
            $oArticles->where('name', 'LIKE', '%' . trim($_GET['name']) . '%');
        }
        if (!empty($_GET['group_id'])) {
            $oArticles->where('group_id', (int) $_GET['group_id']);
        }
        if (!empty($_GET['dateFrom'])) {
            $oArticles->whereDate('created_at', '>=', $_GET['dateFrom']);
        }
        if (!empty($_GET['dateTo'])) {
            $oArticles->whereDate('created_at', '<=', $_GET['dateTo']);
        }
        $oArticles = $oArticles->get();

        $sHtml = '';
        if (count($oArticles) == 0) {
            $sHtml = 'empty';
        } else {
            //foreach ($oArticles as $oArticle) {
            $sHtml = view('layouts/_mainFilter')->with('oArticles', $oArticles)->render();
            /*$sHtml .= '
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        ' . $oArticle['title'] . ', ' . $oArticle['created_at']->format('Y/m/d') . '
                    </div>
                    <div class="panel-body">
                        <p>
                            ' . $oArticle['text'] . '
                        </p>
                        <a href="' . route('articles.show', $oArticle['id']) . '">Подробней -&gt;&gt;</a>
                    </div>
                </div>';*/

            //}
        }
        return json_encode($sHtml);
    }
}
