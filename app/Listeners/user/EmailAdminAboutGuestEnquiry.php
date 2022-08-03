<?php

namespace App\Listeners\user;

use App\Events\user\GuestEnquired;
use App\Mail\GuestEnquiredMessage;
use App\Models\Administrator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailAdminAboutGuestEnquiry
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
     * @param  object  $event
     * @return void
     */
    public function handle(GuestEnquired $event)
    {
        
        $admin = Administrator::select('email')->where('id',1)->first();
        Mail::to($admin->email)->send(new GuestEnquiredMessage($event->payload ));
    }
}
