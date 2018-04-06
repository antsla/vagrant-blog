<?php

namespace App\Http\Controllers\Admin;

use App\Events\onArticleCatActionEvent;
use App\Events\onUserEvent;
use App\Http\Requests\ArticlesCategoryRequest;
use App\Models\ArticleCategory;
use App\Repositories\ArticleCategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class ArticlesCategoriesController extends AdminController
{
    public function __construct(ArticleCategoryRepository $oRep_ac)
    {
        parent::__construct();
        $this->oRep_ac = $oRep_ac;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/articles_categories/index',
            [
                'sTitle' => Lang::get('admin/articles_categories.title_index'),
                'sBreadcrumbs' => 'admin::articles_categories.index',
                'oArticleCategories' => $this->oRep_ac->get('*', 'path')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('changeArticleCategory', new \App\Models\ArticleCategory())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        return view('admin/articles_categories/create', [
            'sTitle' => Lang::get('admin/articles_categories.title_create'),
            'sBreadcrumbs' => 'admin::articles_categories.create',
            'aArticlesCategories' => ['0' => '-'] + $this->oRep_ac->getDropdownFormat()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticlesCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesCategoryRequest $request)
    {
        if (Gate::denies('changeArticleCategory', new \App\Models\ArticleCategory())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        $oResult = $this->oRep_ac->addCategory($request);

        // Если получено исключение
        if ($oResult instanceof \Exception) {
            Event::fire(new onArticleCatActionEvent(new ArticleCategory(), 'error_add', $oResult, $request));
            return redirect(route('admin::articles_categories.index'))
                ->withErrors(['message' => Lang::get('admin/articles_categories.error_add')]);
        }

        Event::fire(new onArticleCatActionEvent($oResult, 'add'));
        return redirect(route('admin::articles_categories.index'))
            ->with(['message' => Lang::get('admin/articles_categories.success_add', ['id' =>  $oResult->id, 'title' =>  $oResult->title])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('changeArticleCategory', new \App\Models\ArticleCategory())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oArticleCategory = $this->oRep_ac->getOne($id);
        } catch (ModelNotFoundException $error) {
            Event::fire(new onUserEvent('not_found'));
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        return view('admin/articles_categories/edit', [
            'sTitle' => 'Редактировать группу',
            'oArticlesCategory' => $oArticleCategory,
            'sBreadcrumbs' => 'admin::articles_categories.edit',
            'aArticlesCategories' => ['0' => '-'] + $this->oRep_ac->getDropdownFormat()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticlesCategoryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticlesCategoryRequest $request, $id)
    {
        if (Gate::denies('changeArticleCategory', new \App\Models\ArticleCategory())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oArticleCategory = $this->oRep_ac->getOne($id);
        } catch (ModelNotFoundException $error) {
            Event::fire(new onUserEvent('not_found'));
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        $oResult = $this->oRep_ac->updCategory($request, $id);

        // Если получено исключение
        if ($oResult instanceof \Exception) {
            Event::fire(new onArticleCatActionEvent(new ArticleCategory(), 'error_upd', $oResult, $id));
            return redirect(route('admin::articles_categories.index'))
                ->withErrors(['message' => Lang::get('admin/articles_categories.error_upd')]);
        }

        Event::fire(new onArticleCatActionEvent($oArticleCategory, 'upd', null, $oResult));

        return redirect(route('admin::articles_categories.index'))
            ->with(['message' => Lang::get('admin/articles_categories.success_upd', ['id' => $oResult->id, 'title' => $oResult->title])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('changeArticleCategory', new \App\Models\ArticleCategory())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        $mResult = $this->oRep_ac->delCategory($id);

        if ($mResult instanceof \Exception) {
            Event::fire(new onArticleCatActionEvent(new ArticleCategory(), 'error_del', $mResult, $id));
            return redirect(route('admin::articles_categories.index'))
                ->withErrors(['message' => Lang::get('admin/articles_categories.error_del')]);
        }

        Event::fire(new onArticleCatActionEvent(new ArticleCategory(), 'del', null, $mResult));
        return redirect(route('admin::articles_categories.index'))
            ->with(['message' => Lang::get('admin/articles_categories.success_del', ['id' => $id])]);
    }
}
