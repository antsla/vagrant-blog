<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class onArticleActionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sType;
    public $oArticle;
    public $oException;
    public $oRequest;

    /**
     * Create a new event instance.
     *
     * @paran \App\Models\Article $oArticle
     * @param string $sType
     * @param \Exception $oException
     * @param \App\Http\Requests\ArticlesRequest|integer $request
     */
    public function __construct(Article $oArticle, $sType, $oException = null, $request = null)
    {
        $this->sType = $sType;
        $this->oArticle = $oArticle;
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
