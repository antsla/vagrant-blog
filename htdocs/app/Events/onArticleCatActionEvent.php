<?php

namespace App\Events;

use App\Models\ArticleCategory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class onArticleCatActionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sType;
    public $oArticle;
    public $oException;
    public $oRequest;

    /**
     * Create a new event instance.
     *
     * @paran \App\Models\ArticleCategory $oArticleCategory
     * @param string $sType
     * @param \Exception $oException
     * @param \App\Http\Requests\ArticlesRequest|integer $request
     */
    public function __construct(ArticleCategory $oArticleCategory, $sType, $oException = null, $request = null)
    {
        $this->sType = $sType;
        $this->oArticleCategory = $oArticleCategory;
        $this->oException = $oException;
        $this->oRequest = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
