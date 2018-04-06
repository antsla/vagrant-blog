<?php

namespace App\Http\Controllers\Admin;

use App\Events\onUserEvent;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class UsersController extends AdminController
{
    public function __construct(UserRepository $oRep_u)
    {
        parent::__construct();
        $this->oRep_u = $oRep_u;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/users/index')
            ->with([
                'oUsers' => $this->oRep_u->get('*', 'created_at', 'desc'),
                'sTitle' => Lang::get('admin/users.title_index'),
                'sBreadcrumbs' => 'admin::users.index',
            ]);
    }

    /**
     * Изменение статуса пользователя
     *
     * @param integer $iId
     * @param string $sType тип операции (bun|unbun)
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($iId, $sType)
    {
        if (Gate::denies('changeUserStatus', new \App\Models\User())) {
            Event::fire(new onUserEvent('permission_denied'));
            return response()->view('admin/errors/403', ['sTitle' => Lang::get('admin/layout.title_403')], 403);
        }

        // Проверка на бан самого себя
        if (Auth::id() == $iId) {
            return back()->withErrors(Lang::get('admin/users.err_yourself_ban'));
        }

        try {
            $oUser = $this->oRep_u->getOne((int) $iId);
        } catch (ModelNotFoundException $oExc) {
            Event::fire(new onUserEvent('not_found'));
            return response()->view('admin/errors/404', ['sTitle' => Lang::get('admin/layout.title_404')], 404);
        }

        $iType = $sType === 'ban' ? 1 : 0;
        $mResult = $this->oRep_u->chgStatus((int) $iId, $iType);

        if ($mResult instanceof \Exception) {
            Event::fire(new onUserEvent('chg_status_err', $oUser, $mResult));
            return back()->withErrors(Lang::get('admin/users.err_change_status_message'));
        }

        if ($iType == 1) {
            Event::fire(new onUserEvent('chg_status_ban', $oUser));
        } else {
            Event::fire(new onUserEvent('chg_status_unban', $oUser));
        }

        return back()->with([
            'message' => Lang::choice('admin/users.change_status_message', $iType, [
                'name' => $oUser->name,
                'id' => $oUser->id,
                'email' => $oUser->email
            ])
        ]);
    }
}
