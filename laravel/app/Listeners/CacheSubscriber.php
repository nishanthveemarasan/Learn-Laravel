<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use illuminate\Cache\Events\CacheHit;
use illuminate\Cache\Events\CacheMissed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CacheSubscriber
{

    public function handleCacheHit(CacheHit $event)
    {
        Log::info("{$event->key} cachehit");
    }
    public function handleCacheMissed(CacheMissed $event)
    {
        Log::info("{$event->key} cachemissed");
    }

    public function subscribe($events)
    {
        $events->listen(
            CacheHit::class,
            [CacheSubscriber::class, 'handleCacheHit']
        );
        $events->listen(
            CacheMissed::class,
            [CacheSubscriber::class, 'handleCacheMissed']
        );
    }
}
