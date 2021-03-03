<?php

namespace App\Ship\Core\Abstracts\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelEventServiceProvider;

/**
 * Class EventsProvider
 */
class EventsProvider extends LaravelEventServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
