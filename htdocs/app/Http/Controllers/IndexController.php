<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleCategoryRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;

class IndexController extends AppController
{
    public function __construct(ArticleRepository $oRep_a, ArticleCategoryRepository $oRep_ac, SliderRepository $oRep_s)
    {
        parent::__construct();

        $this->oRep_a = $oRep_a;
        $this->oRep_ac = $oRep_ac;
        $this->oRep_s = $oRep_s;
    }

    public function index()
    {
        $oUser = Auth::user();
        $this->aMeta['title'] = Lang::get('main.title');
        $sHeadline = Lang::get('main.headline', ['name' => $oUser !== null ? $oUser->name : Lang::get('main.default_name')]);

        return view('index', [
                'oArticles' => $this->oRep_a->get('*', 'created_at', 'desc', true, 5),
                'aArtGr' => $this->oRep_ac->getDropdownFormat(),
                'oSlides' => $this->oRep_s->get(['img', 'text'], 'sort', 'asc'),
                'aMeta' => $this->aMeta,
                'sHeadline' => $sHeadline
            ]
        );
    }

    public function getFilterArticlesAjax(Request $request)
    {
        $oArticles = $this->oRep_a->getByFilter($request->only(['title', 'group_id', 'dateFrom', 'dateTo']));

        if (count($oArticles) == 0) {
            $sHtml = 'empty';
        } else {
            $sHtml = view('includes/_mainFilter')->with('oArticles', $oArticles)->render();
        }
        return json_encode($sHtml);
    }
}
