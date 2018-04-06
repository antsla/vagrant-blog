<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\onArticleActionEvent' => [
            'App\Listeners\ArticleListener',
        ],
        'App\Events\onUserEvent' => [
            'App\Listeners\UserListener',
        ],
        'App\Events\onCommentActionEvent' => [
            'App\Listeners\CommentListener',
        ],
        'App\Events\onArticleCatActionEvent' => [
            'App\Listeners\ArticleCatListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('onErrorMailSend', function($oExc) {
            $oUser = Auth::user();
            Log::error('Пользователь ' . $oUser->name . ' [' . $oUser->id . '] не смог ответить на отзыв.', ['error' => $oExc->getMessage()]);
        });
    }
}
