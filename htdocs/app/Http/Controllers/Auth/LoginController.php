<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    private $aMeta;
    private $sHeadline;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->aMeta = [
            'title' => Lang::get('auth.title_login'),
            'description' => Lang::get('layout.description'),
            'keywords' => Lang::get('layout.keywords')
        ];
        $this->sHeadline = Lang::get('auth.headline_login');
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login', [
            'aMeta' => $this->aMeta,
            'sHeadline' => $this->sHeadline
        ]);
    }
}
