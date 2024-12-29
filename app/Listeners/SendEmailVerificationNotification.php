<?php

namespace App\Listeners;

use App\Events\RequestEmailVerification;
use App\Notifications\Activation;
use Carbon\Carbon;

class SendEmailVerificationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RequestEmailVerification $event): void
    {
        $token = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,6);
        $event->user->verificationToken()->delete();
        $event->user->verificationToken()->create([
            "token" => $token,
            "purpose" => 'Verifikasi email',
            "expired_at" =>  Carbon::now()->addHour()
        ]);
        $event->user->notify(new Activation($event->user, $token));
    }
}
