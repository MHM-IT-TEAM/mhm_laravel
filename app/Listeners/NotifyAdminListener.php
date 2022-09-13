<?php

namespace App\Listeners;

use App\Events\PatientCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PatientCreatedEvent  $event
     * @return void
     */
    public function handle(PatientCreatedEvent $event)
    {

    }
}
