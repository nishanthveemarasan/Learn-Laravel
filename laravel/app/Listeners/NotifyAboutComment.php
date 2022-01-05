<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersPostCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAboutComment
{

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentPosted  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        NotifyUsersPostCreated::dispatch($event->post)->onConnection('database')->onQueue('high');
    }
}
