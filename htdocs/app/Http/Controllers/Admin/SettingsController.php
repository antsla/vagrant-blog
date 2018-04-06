<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;

class SettingsController extends AdminController
{
    public function __construct(SettingRepository $oRep_set)
    {
        parent::__construct();
        $this->oRep_set = $oRep_set;
    }

    public function index()
    {
        if (Gate::denies('changeSetting', new Setting())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        return view('admin/settings', [
            'sTitle' => Lang::get('admin/settings.title_index'),
            'sBreadcrumbs' => 'admin::settings.index'
        ]);
    }

    public function getSettingsAjax()
    {
        if (Gate::denies('changeSetting', new Setting())) {
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        return Response::json($this->oRep_set->get());
    }

    public function addSettingAjax(Request $request)
    {
        if (Gate::denies('changeSetting', new Setting())) {
            return Response::json(['result' => 'error', 'content' => Lang::get('admin/settings.err_forbidden')]);
        }

        $oRes = $this->oRep_set->addSetting($request);
        if ($oRes instanceof \Exception) {
            return Response::json(['result' => 'error', 'content' => Lang::get('admin/settings.err_save')]);
        }

        return Response::json(['result' => 'success', 'content' => $oRes]);
    }

    public function updSettingAjax(Request $request)
    {
        if (Gate::denies('changeSetting', new Setting())) {
            return Response::json(['result' => 'error', 'content' => Lang::get('admin/settings.err_forbidden')]);
        }

        $oRes = $this->oRep_set->updSetting($request->id, $request);
        if ($oRes instanceof \Exception) {
            return Response::json(['result' => 'error', 'content' => Lang::get('admin/settings.err_update')]);
        }

        return Response::json(['result' => 'success', 'content' => Lang::get('admin/settings.suc_update')]);
    }

    public function delSettingAjax(Request $request)
    {
        if (Gate::denies('changeSetting', new Setting())) {
            return Response::json(['result' => 'error', 'content' => Lang::get('admin/settings.err_forbidden')]);
        }

        $oRes = $this->oRep_set->delSetting($request->id);
        if ($oRes instanceof \Exception) {
            return Response::json(['result' => 'error', 'content' => Lang::get('admin/settings.err_delete')]);
        }

        return Response::json(['result' => 'success', 'content' => Lang::get('admin/settings.suc_delete')]);
    }
}
