<?php

namespace App\Http\Controllers;

use App\Repositories\FeedbackRepository;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends AppController
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
        $this->aMeta['title'] = Lang::get('feedback.title');
        return view('feedback')->with([
            'aMeta' => $this->aMeta,
            'sHeadline' => Lang::get('feedback.headline')
        ]);
    }

    public function sendAjax(Request $request)
    {
        $oValidator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'text' => 'required|min:20'
        ]);
        if ($oValidator->fails()) {
            return Response::json(['fail' => true, 'message' => implode('<br />', $oValidator->messages()->all())]);
        }

        if ($this->oRep_f->addFeedback($request->only(['name', 'email', 'text']))) {
            return Response::json(['success' => true, 'message' => Lang::get('feedback.add_success')]);
        }

        return Response::json(['fail' => true, 'message' => Lang::get('feedback.add_error')]);
    }
}
