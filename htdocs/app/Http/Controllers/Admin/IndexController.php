<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class IndexController extends AdminController
{
    public function index()
    {
        return view('admin/index', [
            'sTitle' => Lang::get('admin/layout.title'),
            'sBreadcrumbs' => 'admin::index',
            'sHeadline' => Lang::get('admin/layout.headline', ['name' => Auth::user()->name])
        ]);
    }
}
