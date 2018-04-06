<?php

namespace App\Repositories;

use App\Models\ArticleComment;
use Illuminate\Support\Facades\DB;

class ArticleCommentRepository extends Repository
{
    public function __construct(ArticleComment $oArticleComm)
    {
        parent::__construct();
        $this->oModel = $oArticleComm;
    }

    /**
     * Получение комментария в виде массива
     *
     * @param int $iId идентификатор комментария
     * @return array
     */
    public function getComment($iId)
    {
        return $this->oModel->find($iId)->toArray();
    }

    /**
     * Обновление комментария
     *
     * @param \App\Http\Requests\CommentRequest $request
     * @return \App\Models\ArticleComment|\Exception
     */
    public function updComment($request)
    {
        $iId = (int) $request->id;
        DB::beginTransaction();
        try {
            $oComment = $this->oModel->findOrFail((int) $iId);
            $oComment->text = strip_tags(trim($request->text));
            $oComment->save();
            DB::commit();
            return $oComment;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }

    /**
     * Добавление комментария в БД
     *
     * @param int $id идентификатор статьи, для которой добавляется комментарий
     * @param object $request данные
     */
    public function addComment($id, $request)
    {
        if ($request->response_id == 0) {
            // Если родительского узла нет
            $iRightKey = $this->oModel->max('right_key') + 1;
            $iLevel = 0;
        } else {
            // Информация о родительском узле
            $aParentInfo = $this->oModel->where('id', $request->response_id)->get(['right_key', 'level'])->first()->toArray();
            $iRightKey = $aParentInfo['right_key'];
            $iLevel = $aParentInfo['level'];
        }

        DB::beginTransaction();

        //Обновляем ключи существующего дерева, узлы стоящие за родительским узлом; Обновляем родительскую ветку
        DB::update('UPDATE ' . $this->sTablePrefix .'articles_comments
                          SET right_key = right_key + 2,
                            left_key = IF(left_key > :rKey, left_key + 2, left_key)
                          WHERE right_key >= :rKey', ['rKey' => $iRightKey]);

        $aData = [
            //> Добавление нового узла
            'article_id' => (int) $id,
            'left_key' => $iRightKey,
            'right_key' => $iRightKey + 1,
            'level' => $iLevel + 1,
            //<
            'username' => $request->name,
            'text' => htmlentities(strip_tags(trim($request->text))),
            'parent_id' => (int)$request->response_id
        ];
        $this->oModel->fill($aData)->push();

        DB::commit();
    }

    /**
     * Удаление комментария
     *
     * @param int $id
     * @return bool|\Exception
     */
    public function delComment($id)
    {
        try {
            if (!$this->oModel->destroy($id)) {
                throw new \Exception('Комментарий не найден!');
            }
            return true;
        } catch (\Exception $oExc) {
            return $oExc;
        }
    }

    /**
     * Восстановление комментария
     *
     * @param int $id
     * @return bool|\Exception
     */
    public function resComment($id)
    {
        DB::beginTransaction();
        try {
            $oComment = $this->oModel->withTrashed()->findOrFail($id);
            $oComment->restore();
            DB::commit();
            return true;
        } catch (\Exception $oExc) {
            DB::rollback();
            return $oExc;
        }
    }
}