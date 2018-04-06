<?php

namespace App\Listeners;

use App\Events\onArticleCatActionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleCatListener
{
    private $oUser;

    public function __construct()
    {
        $this->oUser = Auth::user();
    }

    /**
     * Handle the event.
     *
     * @param  onArticleCatActionEvent  $oEvent
     * @return void
     */
    public function handle(onArticleCatActionEvent $oEvent)
    {
        switch ($oEvent->sType) {
            case 'error_add':
                Log::error('Ошибка добавления категории, пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                        'new_values' => [
                            'title' => $oEvent->oRequest->ac_name,
                            'parent_id' => $oEvent->oRequest->ac_parent_id,
                        ],
                    ]
                );
                break;
            case 'add':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' добавил новую категорию.',
                    [
                        'id' => $oEvent->oArticleCategory->id,
                        'title' => $oEvent->oArticleCategory->title,
                        'parent_id' => $oEvent->oArticleCategory->parent_id,
                        'level' => $oEvent->oArticleCategory->level,
                        'path' => $oEvent->oArticleCategory->path,
                    ]
                );
                break;
            case 'error_upd':
                Log::error('Ошибка обновления категории [' . $oEvent->oRequest . '], пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                    ]
                );
                break;
            case 'upd':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' обновил категорию ' . $oEvent->oArticleCategory->id . '.',
                    [
                        'old_values' => [
                            'id' => $oEvent->oArticleCategory->id,
                            'title' => $oEvent->oArticleCategory->title,
                            'parent_id' => $oEvent->oArticleCategory->parent_id,
                            'level' => $oEvent->oArticleCategory->level,
                            'path' => $oEvent->oArticleCategory->path,
                        ],
                        'new_values' => [
                            'id' => $oEvent->oRequest->id,
                            'title' => $oEvent->oRequest->title,
                            'parent_id' => $oEvent->oRequest->parent_id,
                            'level' => $oEvent->oRequest->level,
                            'path' => $oEvent->oRequest->path,
                        ],
                    ]
                );
                break;
            case 'error_del':
                Log::error('Ошибка удаления категории [' . $oEvent->oRequest . '], пользователь [' . $this->oUser->id . ']' . $this->oUser->name . '.',
                    [
                        'error_message' => $oEvent->oException->getMessage(),
                    ]
                );
                break;
            case 'del':
                Log::info('Пользователь [' . $this->oUser->id . ']' . $this->oUser->name . ' удалил категорию и подкатегории.',
                    [
                        'ids' => $oEvent->oRequest
                    ]
                );
                break;
        }
    }
}
