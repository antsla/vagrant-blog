<?php

namespace App\Http\Controllers\Admin;

use App\Events\onUserEvent;
use App\Repositories\FeedbackRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends AdminController
{
    public function __construct(FeedbackRepository $oRep_f)
    {
        parent::__construct();
        $this->oRep_f = $oRep_f;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/feedback/index')->with([
            'sTitle' => Lang::get('admin/feedback.title_index'),
            'sBreadcrumbs' => 'admin::feedback.index',
            'oFeedback' => $this->oRep_f->get('*'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('responseToReview', new \App\Models\Feedback())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        try {
            $oReview = $this->oRep_f->getOne($id);
        } catch (ModelNotFoundException $oExc) {
            Event::fire(new onUserEvent('not_found'));
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        return view('admin/feedback/show')->with([
            'sTitle' => $this->sTitle,
            'sBreadcrumbs' => 'admin::feedback.show',
            'oReview' => $oReview
        ]);
    }

    /**
     * Функция ответа на отзыв
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function response(Request $request, $id)
    {
        if (Gate::denies('responseToReview', new \App\Models\Feedback())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        //> Валидация
        $oValidator = Validator::make($request->only('fb_response_text'), [
            'fb_response_text' => 'required|min:10'
        ], [
            'fb_response_text.required' => Lang::get('admin/feedback.valid_req_text'),
            'fb_response_text.min' => Lang::get('admin/feedback.valid_min_text', ['min' => 10]),
        ]);
        if ($oValidator->fails()) {
            return redirect(route('admin::feedback.show', $id))
                ->withErrors($oValidator->errors()->all())
                ->withInput($request->only('fb_response_text'));
        }
        //<

        // Отправка письма
        try {
            $sResponseText = trim(strip_tags($request->fb_response_text));
            $oReview = $this->oRep_f->getOne($id);
            Mail::send('admin/emails_templates.review_response', array('sText' => $sResponseText), function ($oMail) use ($oReview) {
                $oMail->from('slavka20082008@yandex.ru', 'BlankAppAdmin');
                $oMail->to($oReview->email, $oReview->name)->subject(Lang::get('admin/feedback.response_theme'));
            });
        } catch (\Exception $oExc) {
            Event::fire('onErrorMailSend', $oExc);
            return redirect(route('admin::feedback.show', $id))
                ->withErrors(Lang::get('admin/feedback.error_send'))
                ->withInput($request->only('fb_response_text'));
        }
        //<

        return redirect(route('admin::feedback.show', $id))->with(['message' => Lang::get('admin/feedback.success_send')]);
    }
}
