<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ArticleRepository extends Repository
{
    public function __construct(Article $oArticle)
    {
        parent::__construct();
        $this->oModel = $oArticle;
    }

    /**
     * @param array $request get-массив данных фильтра
     * @return object
     */
    public function getByFilter($request)
    {
        $oArticles = $this->oModel->orderBy('created_at', 'desc');

        if (!empty($request['title'])) {
            $oArticles->where('title', 'LIKE', '%' . trim($request['title']) . '%');
        }
        if (!empty($request['group_id'])) {
            $oArticles->where('group_id', (int) $request['group_id']);
        }
        if (!empty($request['dateFrom'])) {
            $oArticles->whereDate('created_at', '>=', $request['dateFrom']);
        }
        if (!empty($request['dateTo'])) {
            $oArticles->whereDate('created_at', '<=', $request['dateTo']);
        }
        $oArticles = $oArticles->get();
        return $oArticles;
    }

    /**
     * Получение модели по id
     *
     * @param int $id
     * @return \App\Models\Article
     */
    public function getOne($id)
    {
        return $this->oModel->with(['comments' => function ($query) {
            $query->orderBy('left_key');
        }])->where('id', $id)->firstOrFail();
    }

    /**
     * Добавление статьи
     *
     * @param object $request
     * @return \App\Models\Article|\Exception
     */
    public function addArticle($request)
    {
        DB::beginTransaction();
        try {
            /*$this->oModel->fill([
                'title' => strip_tags(trim($request->a_name)),
                'text' => strip_tags(trim($request->a_text)),
                'group_id' => (int) $request->a_group_id
            ])->push();*/
            $this->oModel->title = strip_tags(trim($request->a_name));
            $this->oModel->text = strip_tags(trim($request->a_text));
            $this->oModel->group_id = (int) $request->a_group_id;
            $this->oModel->save();
            DB::commit();
            return $this->oModel;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }

    /**
     * Обновление статьи
     *
     * @param object $request
     * @param int $id
     * @return \App\Models\Article|\Exception
     */
    public function updArticle($request, $id)
    {
        DB::beginTransaction();
        try {
            /*$this->oModel->where('id', $id)->update([
                'title' => strip_tags(trim($request->a_name)),
                'text' => strip_tags(trim($request->a_text)),
                'group_id' => (int) $request->a_group_id
            ]);*/
            $oArticle = $this->oModel->findOrFail($id);
            $oArticle->title = strip_tags(trim($request->a_name));
            $oArticle->text = strip_tags(trim($request->a_text));
            $oArticle->group_id = (int) $request->a_group_id;
            $oArticle->save();
            DB::commit();
            return $oArticle;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }

    /**
     * Удаление статьи
     *
     * @param int $id
     * @return bool|\Exception
     */
    public function delArticle($id)
    {
        DB::beginTransaction();
        try {
            $oArticle = $this->oModel->findOrFail($id);
            $oArticle->comments()->delete();
            $oArticle->delete();
            DB::commit();
            return true;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }

}