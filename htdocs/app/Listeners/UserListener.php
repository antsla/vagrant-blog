<?php

namespace App\Listeners;

use App\Events\onUserEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserListener
{

    private $oUser;

    public function __construct()
    {
        $this->oUser = Auth::user();
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\onUserEvent  $oEvent
     * @return void
     */
    public function handle(onUserEvent $oEvent)
    {
        switch ($oEvent->sType) {
            case 'permission_denied':
                Log::warning('Попытка пользователя [' . $this->oUser->id . ']' . $this->oUser->name . ' обратиться к запрещенному адресу [ ' . url()->current() . ' ].');
                break;
            case 'not_found':
                Log::warning('Попытка пользователя [' . $this->oUser->id . ']' . $this->oUser->name . ' обратиться к несуществующему адресу [ ' . url()->current() . ' ].');
                break;
            case 'chg_status_err':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' попытался изменить статус пользователя [' . $oEvent->oHandleUser->id . ']' . $oEvent->oHandleUser->name, [
                    'error_message' => $oEvent->oException->getMessage()
                ]);
                break;
            case 'chg_status_ban':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' забанил пользователя [' . $oEvent->oHandleUser->id . ']' . $oEvent->oHandleUser->name);
                break;
            case 'chg_status_unban':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' разбанил пользователя [' . $oEvent->oHandleUser->id . ']' . $oEvent->oHandleUser->name);
                break;
        }
    }
}
