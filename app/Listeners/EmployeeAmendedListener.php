<?php

namespace App\Listeners;

use App\Events\EmployeeAmended;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeAmendedListener
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
     * @param  EmployeeAmended  $event
     * @return void
     */
    public function handle(EmployeeAmended $event)
    {
        //
    }
}
