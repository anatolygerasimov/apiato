<?php

namespace App\Ship\Core\Abstracts\Events\Jobs;

use App\Ship\Core\Abstracts\Events\Interfaces\ShouldHandle;
use App\Ship\Core\Abstracts\Jobs\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class EventJob.
 */
class EventJob extends Job implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $handler;

    /**
     * EventJob constructor.
     *
     * @param ShouldHandle $handler
     */
    public function __construct(ShouldHandle $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Handle the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->handler->handle();
    }
}
