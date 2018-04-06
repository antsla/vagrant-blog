<?php

namespace App\Events;

use App\Models\ArticleComment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class onCommentActionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sType;
    public $oComment;
    public $oException;
    public $oRequest;

    /**
     * Create a new event instance.
     *
     * @paran \App\Models\rticleComment $oComment
     * @param string $sType
     * @param \Exception $oException
     * @param \App\Http\Requests\ArticlesRequest|integer $request
     */
    public function __construct(ArticleComment $oComment, $sType, $oException = null, $request = null)
    {
        $this->sType = $sType;
        $this->oComment = $oComment;
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
