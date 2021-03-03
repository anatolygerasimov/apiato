<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\EventsProvider as AbstractEventsProvider;

/**
 * Class EventsProvider
 *
 * A.K.A app/Providers/EventsServiceProvider.php
 */
class EventsProvider extends AbstractEventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];


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
