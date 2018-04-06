<?php

namespace App\Listeners;

use App\Events\onCommentActionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentListener
{
    private $oUser;

    public function __construct()
    {
        $this->oUser = Auth::user();
    }

    /**
     * Handle the event.
     *
     * @param  onCommentActionEvent  $oEvent
     * @return void
     */
    public function handle(onCommentActionEvent $oEvent)
    {
        switch ($oEvent->sType) {
            case 'error_upd':
                Log::error('Ошибка обновления комментария [' . $oEvent->oRequest . '], пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                    ]
                );
                break;
            case 'upd':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' обновил комментарий ' . $oEvent->oComment->id . '.',
                    [
                        'old_values' => [
                            'text' => $oEvent->oComment->text
                        ],
                        'new_values' => [
                            'text' => $oEvent->oRequest->text
                        ],
                    ]
                );
                break;
            case 'error_del':
                Log::error('Ошибка удаления комментария [' . $oEvent->oRequest . '], пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                    ]
                );
                break;
            case 'del':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' удалил комментарий.',
                    [
                        'id' => $oEvent->oRequest
                    ]
                );
                break;
            case 'error_res':
                Log::error('Ошибка восстановления комментария [' . $oEvent->oRequest . '], пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                    ]
                );
                break;
            case 'res':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' восстановил комментарий.',
                    [
                        'id' => $oEvent->oRequest
                    ]
                );
                break;
        }
    }
}
