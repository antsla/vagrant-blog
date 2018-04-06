<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class AdminController extends Controller
{
    protected $oRep_a; // репозиторий статей
    protected $oRep_ac; // репозиторий категорий статей
    protected $oRep_acm; // репозиторий комментариев статей
    protected $oRep_s; // репозиторий слайдов
    protected $oRep_set; // репозиторий настроек
    protected $oRep_f; // репозиторий отзывов
    protected $oRep_u; // репозиторий юзеров
    protected $oRep_pl; // репозиторий парсящихся таблиц

    protected $sTitle;

    public function __construct()
    {
        $this->sTitle = Lang::get('admin/layout.title');
    }
}
