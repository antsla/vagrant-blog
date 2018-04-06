<?php

namespace App\Http\Controllers;

use App\Events\onUserEvent;
use App\Http\Requests\CommentRequest;
use App\Repositories\ArticleCommentRepository;
use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;

class ArticlesController extends AppController
{
    public function __construct(ArticleRepository $oRep_a, ArticleCommentRepository $oRep_acm)
    {
        parent::__construct();
        $this->oRep_a = $oRep_a;
        $this->oRep_acm = $oRep_acm;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $oArticle = $this->oRep_a->getOne($id);
        } catch (ModelNotFoundException $oExc) {
            Event::fire(new onUserEvent('not_found'));
            return $this->getError404();
        }
        //dd($this->aMeta);

        return view('articles/single', [
            'aMeta' => $this->aMeta,
            'sBreadcrumbs' => 'article.show',
            'oArticle' => $oArticle,
        ]);
    }

    /**
     * @param int $id
     * @param CommentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveComment($id, CommentRequest $request)
    {
        $this->oRep_acm->addComment($id, $request);

        return redirect(route('articles.show', $id))->with(['message' => Lang::get('articles.success_add')]);
    }
}
