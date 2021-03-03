<?php

namespace App\Ship\Core\Abstracts\Events\Providers;

use App\Ship\Core\Abstracts\Events\Dispatcher\Dispatcher;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Events\EventServiceProvider as LaravelEventServiceProvider;

class EventServiceProvider extends LaravelEventServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->singleton('events', function ($app) {
            return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
                return $app->make(QueueFactoryContract::class);
            });
        });
    }
}
