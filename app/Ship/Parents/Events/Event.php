<?php

namespace App\Ship\Parents\Events;

use App\Ship\Core\Abstracts\Events\Event as AbstractEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

/**
 * Class Event
 */
abstract class Event extends AbstractEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
}
