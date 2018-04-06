<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\DB;

class ArticleCategoryRepository extends Repository
{
    private $oArticle;

    public function __construct(ArticleCategory $oArticleCat, Article $oArticle)
    {
        parent::__construct();
        $this->oModel = $oArticleCat;
        $this->oArticle = $oArticle;
    }

    /**
     * Функция возвращает массив категорий в удобочитаемом виде
     *
     * @return array
     */
    public function getDropdownFormat()
    {
        return $this->oModel->select(DB::raw('CONCAT (REPEAT(" -> ", level - 1), title) as name'), 'id')
            ->orderBy('path')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Добавление новой категории для статей
     *
     * @param \App\Http\Requests\ArticlesCategoryRequest $request данные
     * @return \App\Models\ArticleCategory|\Exception
     */
    public function addCategory($request)
    {
        try {
            $iParentId = (int)$request->ac_parent_id;

            if ($iParentId === 0) {
                // Новая запись добавляется в корень
                $iNewPath = $this->oModel->where('parent_id', 0)->max('path') + 1;
                $iNewLevel = 1;
            } else {
                // Новая запись добавляется не в корень
                $oPrevInfo = DB::select('SELECT MAX(path) as path, level
                                        FROM ' . $this->sTablePrefix . 'articles_categories
                                        WHERE path REGEXP CONCAT("^", (
                                          SELECT path
                                          FROM ' . $this->sTablePrefix . 'articles_categories
                                          WHERE id = ?
                                        ), ".[0-9]+$") GROUP BY level', [$iParentId]);

                if (empty($oPrevInfo) || $oPrevInfo[0]->path === null) {
                    // У родителя нет потомков
                    $oCurrInfo = $this->oModel->find($iParentId)->toArray();
                    $iNewPath = $oCurrInfo['path'] . '.1';
                    $iNewLevel = $oCurrInfo['level'] + 1;
                } else {
                    // Потомки есть
                    $iNewPath = preg_replace_callback('#(\d+)$#', function ($match) {
                        return (int)$match[1] + 1;
                    }, $oPrevInfo[0]->path);
                    $iNewLevel = $oPrevInfo[0]->level;
                }
            }

            $this->oModel->title = trim(strip_tags($request->ac_name));
            $this->oModel->parent_id = (int) $iParentId;
            $this->oModel->path = $iNewPath;
            $this->oModel->level = (int) $iNewLevel;
            $this->oModel->save();
            return $this->oModel;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Обновление категории статей
     *
     * @param \App\Http\Requests\ArticlesCategoryRequest $request данные
     * @param integer $id
     * @return \App\Models\ArticleCategory|\Exception
     */
    public function updCategory($request, $id)
    {
        try {
            //Получаем обновляемую запись
            $oArticlesCategory = $this->oModel->find($id);
            $iNewParentId = $request->ac_parent_id;

            //> Если родитель записи меняется, то перемещаем дерево
            if ($oArticlesCategory->parent_id !== $iNewParentId) {
                //> Вычисляем новый путь для дерева
                if ($iNewParentId == 0) {
                    $iNewPath = $this->oModel->where('parent_id', '0')->max('path') + 1;
                } else {
                    $iPrevInfo = DB::select('SELECT max(path) as path
                                      FROM ' . $this->sTablePrefix . 'articles_categories
                                      WHERE path REGEXP CONCAT("^", (
                                        SELECT path
                                        FROM ' . $this->sTablePrefix . 'articles_categories
                                        WHERE id = ?
                                        ), ".[0-9]+$")', array($iNewParentId))[0]->path;

                    if ($iPrevInfo === null) {
                        // Записей потомков нет
                        $iNewPath = $this->oModel->find($iNewParentId)->toArray()['path'] . '.1';
                    } else {
                        // Записи потомки есть
                        $iNewPath = preg_replace_callback('#(\d+)$#', function ($match) {
                            return (int)$match[1] + 1;
                        }, $iPrevInfo);
                    }
                }
                //<

                //> Получаем список id, которые надо переместить по дереву
                $oUpdArticlesGroups = DB::select('SELECT id, level, parent_id, path
                            FROM ' . $this->sTablePrefix . 'articles_categories
                            WHERE path LIKE CONCAT((
                              SELECT path
                               FROM ' . $this->sTablePrefix . 'articles_categories
                               WHERE id = ?
                            ), "%")
                            ORDER BY path', array($id));
                $sRootPath = $oArticlesCategory->path;
                //<

                //> Обновляем дерево подконтрольных записей
                DB::beginTransaction();
                foreach ($oUpdArticlesGroups as $oUpdArticlesGroup) {
                    if ($oUpdArticlesGroup->id === $id) {
                        $aUpdating['parent_id'] = $iNewParentId;
                    } else {
                        $aUpdating['parent_id'] = $oUpdArticlesGroup->parent_id;
                    }
                    $aUpdating['path'] = preg_replace('#^' . $sRootPath . '#', $iNewPath, $oUpdArticlesGroup->path);
                    $aUpdating['level'] = substr_count($aUpdating['path'], '.') + 1;

                    $this->oModel->where('id', $oUpdArticlesGroup->id)->update($aUpdating);
                }
                DB::commit();
                //<
            }
            //<
            DB::rollback();
            $oArticlesCategory->title = trim(strip_tags($request->ac_name));
            $oArticlesCategory->save();
            return $this->oModel->find($id);
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Удалении категории статей
     *
     * @param integer $id
     * @return string|\Exception
     */
    public function delCategory($id)
    {
        DB::beginTransaction();
        try {
            $oDelArticleGroup = $this->oModel->find((int)$id);
            $sIds = DB::select('SELECT GROUP_CONCAT(id) as ids FROM ' . $this->sTablePrefix . 'articles_categories WHERE path LIKE CONCAT(?, "%")', array($oDelArticleGroup->path))[0]->ids;
            $this->oModel->destroy(explode(',', $sIds));
            $this->oArticle->whereIn('group_id', explode(',', $sIds))
                ->update(['group_id' => 0]);
            DB::commit();
            return $sIds;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }

}