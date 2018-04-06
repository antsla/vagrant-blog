<?php

namespace App\Http\Controllers;

use App\Events\onCommentActionEvent;
use App\Events\onUserEvent;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Repositories\ArticleCommentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Request;

class CommentsController extends AppController
{
    public function __construct(ArticleCommentRepository $oRep_acm)
    {
        parent::__construct();
        $this->oRep_acm = $oRep_acm;
    }

    public function getCommentAjax(Request $request)
    {
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->json(['result' => 'error', 'message' => Lang::get('layout.perm_denied')]);
        }
        $iId = (int) $request->id;
        return response()->json(['result' => 'success', 'data' => $this->oRep_acm->getComment($iId)]);
    }

    public function updateCommentAjax(Request $request)
    {
        $iId = (int) $request->id;
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->json(['result' => 'error', 'message' => Lang::get('layout.perm_denied')]);
        }

        try {
            $oComment = $this->oRep_acm->getOne($iId);
        } catch (ModelNotFoundException $error) {
            Event::fire(new onUserEvent('not_found'));
            return response()->json(['result' => 'error', 'message' => Lang::get('articles.comment_not_found')]);
        }

        $oResult = $this->oRep_acm->updComment($request);

        // Если получено исключение
        if ($oResult instanceof \Exception) {
            Event::fire(new onCommentActionEvent(new ArticleComment(), 'error_upd', $oResult, $iId));
            return response()->json(['result' => 'error', 'message' => Lang::get('articles.error_comment_upd')]);
        }

        Event::fire(new onCommentActionEvent($oComment, 'upd', null, $oResult));
        return response()->json(['result' => 'success', 'message' => Lang::get('articles.success_comment_upd'), 'data' => $oResult]);
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
            return redirect()->back()->withErrors(['message' => Lang::get('articles.error_comm_del')]);
        }

        $mResult = $this->oRep_acm->delComment($id);

        if ($mResult instanceof \Exception) {
            Event::fire(new onCommentActionEvent(new ArticleComment(), 'error_del', $mResult, $id));
            return redirect()->back()->withErrors(['message' => Lang::get('articles.error_comm_del')]);
        }

        Event::fire(new onCommentActionEvent(new ArticleComment(), 'del', null, $id));
        return redirect()->back()
            ->with(['message' => Lang::get('articles.success_comment_del', ['id' => $id])]);

    }

    /**
     * Восстановлнеие удаленного комментария
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (Gate::denies('changeArticle', new Article())) {
            Event::fire(new onUserEvent('permission_denied'));
            return redirect()->back()->withErrors(['message' => Lang::get('articles.error_comm_res')]);
        }

        $mResult = $this->oRep_acm->resComment($id);

        if ($mResult instanceof \Exception) {
            Event::fire(new onCommentActionEvent(new ArticleComment(), 'error_res', $mResult, $id));
            return redirect()->back()->withErrors(['message' => Lang::get('articles.error_comm_res')]);
        }

        Event::fire(new onCommentActionEvent(new ArticleComment(), 'res', null, $id));
        return redirect()->back()
            ->with(['message' => Lang::get('articles.success_comment_res', ['id' => $id])]);

    }
}
