<?php

namespace App\Listeners;

use App\Events\onArticleActionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleListener
{
    private $oUser;

    public function __construct()
    {
        $this->oUser = Auth::user();
    }

    /**
     * Handle the event.
     *
     * @param  onArticleActionEvent $oEvent
     * @return void
     */
    public function handle(onArticleActionEvent $oEvent)
    {
        switch ($oEvent->sType) {
            case 'error_add':
                Log::error('Ошибка добавления статьи, пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                        'new_values' => [
                            'title' => $oEvent->oRequest->a_name,
                            'text' => $oEvent->oRequest->a_text,
                            'group_id' => $oEvent->oRequest->a_group_id,
                        ],
                    ]
                );
                break;
            case 'add':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' добавил новую статью.',
                    [
                        'id' => $oEvent->oArticle->id,
                        'title' => $oEvent->oArticle->title,
                    ]
                );
                break;
            case 'error_upd':
                Log::error('Ошибка обновления статьи [' . $oEvent->oRequest . '], пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                    ]
                );
                break;
            case 'upd':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' обновил статью ' . $oEvent->oArticle->id . '.',
                    [
                        'old_values' => [
                            'title' => $oEvent->oArticle->title,
                            'text' => $oEvent->oArticle->text,
                            'group_id' => $oEvent->oArticle->group_id,
                        ],
                        'new_values' => [
                            'title' => $oEvent->oRequest->title,
                            'text' => $oEvent->oRequest->text,
                            'group_id' => $oEvent->oRequest->group_id,
                        ],
                    ]
                );
                break;
            case 'error_del':
                Log::error('Ошибка удаления статьи [' . $oEvent->oRequest . '], пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                    ]
                );
                break;
            case 'del':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' удалил статью и связанные комментарии.',
                    [
                        'id' => $oEvent->oRequest
                    ]
                );
                break;
        }
    }
}
