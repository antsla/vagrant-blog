<?php

namespace App\Http\Controllers\Admin;

use App\Events\onArticleActionEvent;
use App\Events\onUserEvent;
use App\Http\Requests\ArticlesRequest;
use App\Models\Article;
use App\Repositories\ArticleCategoryRepository;
use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class ArticlesController extends AdminController
{
    public function __construct(ArticleRepository $oRep_a, ArticleCategoryRepository $oRep_ac)
    {
        parent::__construct();
        $this->oRep_a = $oRep_a;
        $this->oRep_ac = $oRep_ac;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/articles/index', [
            'sTitle' => Lang::get('admin/articles.title_index'),
            'sBreadcrumbs' => 'admin::articles.index',
            'oArticles' => $this->oRep_a->get('*', 'id', 'desc', true, '5', 'group'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        return view('admin/articles/create', [
            'sTitle' => Lang::get('admin/articles.title_create'),
            'sBreadcrumbs' => 'admin::articles.create',
            'aArticlesCategories' => ['0' => '-'] + $this->oRep_ac->getDropdownFormat(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticlesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesRequest $request)
    {
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        $oResult = $this->oRep_a->addArticle($request);

        // Если получено исключение
        if ($oResult instanceof \Exception) {
            Event::fire(new onArticleActionEvent(new Article(), 'error_add', $oResult, $request));
            return redirect(route('admin::articles.index'))
                ->withErrors(['message' => Lang::get('admin/articles.error_add')]);
        }

        Event::fire(new onArticleActionEvent($oResult, 'add'));
        return redirect(route('admin::articles.index'))
            ->with(['message' => Lang::get('admin/articles.success_add', ['id' => $oResult->id, 'title' => $oResult->title])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oArticle = $this->oRep_a->getOne($id);
        } catch (ModelNotFoundException $error) {
            Event::fire(new onUserEvent('not_found'));
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        return view('admin/articles/edit', [
            'sTitle' => Lang::get('admin/articles.title_edit'),
            'sBreadcrumbs' => 'admin::articles.edit',
            'oArticle' => $oArticle,
            'aArticlesCategories' => ['0' => '-'] + $this->oRep_ac->getDropdownFormat()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticlesRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticlesRequest $request, $id)
    {
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oArticle = $this->oRep_a->getOne($id);
        } catch (ModelNotFoundException $error) {
            Event::fire(new onUserEvent('not_found'));
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        $oResult = $this->oRep_a->updArticle($request, $id);

        // Если получено исключение
        if ($oResult instanceof \Exception) {
            Event::fire(new onArticleActionEvent(new Article(), 'error_upd', $oResult, $id));
            return redirect(route('admin::articles.index'))
                ->withErrors(['message' => Lang::get('admin/articles.error_upd')]);
        }

        Event::fire(new onArticleActionEvent($oArticle, 'upd', null, $oResult));

        return redirect(route('admin::articles.index'))
            ->with(['message' => Lang::get('admin/articles.success_upd', ['id' => $oResult->id, 'title' => $oResult->title])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        $mResult = $this->oRep_a->delArticle($id);
        if ($mResult instanceof \Exception) {
            Event::fire(new onArticleActionEvent(new Article(), 'error_del', $mResult, $id));
            return redirect(route('admin::articles.index'))
                ->withErrors(['message' => Lang::get('admin/articles.error_del')]);
        }

        Event::fire(new onArticleActionEvent(new Article(), 'del', null, $id));
        return redirect(route('admin::articles.index'))
            ->with(['message' => Lang::get('admin/articles.success_del', ['id' => $id])]);

    }

}
