<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;

class AppController extends Controller
{
    protected $oRep_a; // репозиторий статей
    protected $oRep_ac; // репозиторий категорий статей
    protected $oRep_acm; // репозиторий комментариев статей
    protected $oRep_s; // репозиторий слайдов
    protected $oRep_f; // репозиторий отзывов

    protected $aMeta;

    public function __construct()
    {
        $this->aMeta = [
            'title' => Lang::get('layout.title'),
            'description' => Lang::get('layout.description'),
            'keywords' => Lang::get('layout.keywords')
        ];
    }

    protected function getError404() {
        return response()->view('errors.404', ['aMeta' => [
                'title' => Lang::get('layout.title_404'),
                'description' => Lang::get('layout.description_404'),
                'keywords' => Lang::get('layout.keywords_404')
            ]
        ], 404);
    }
}
