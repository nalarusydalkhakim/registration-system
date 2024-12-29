<?php

namespace App\Listeners;

use App\Events\RequestPasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Notifications\PasswordReset;

class SendEmailRequestPasswordResetNotification
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
    public function handle(RequestPasswordReset $event): void
    {
        $user = $event->user;
        $token = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 6);
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        DB::table('password_reset_tokens')->insert(
            [
                'email' => $user->email,
                'token' => $token
            ]
        );
        $user->notify(new PasswordReset($user, $token));
    }
}
