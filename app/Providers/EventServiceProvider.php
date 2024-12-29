<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\RequestEmailVerification;
use App\Listeners\SendEmailVerificationNotification;

use App\Events\EmailVerified;
use App\Listeners\SendEmailVerifiedNotification;
use App\Listeners\SetEmailVerified;
use App\Listeners\RemoveVerificationToken;

use App\Events\RequestPasswordReset;
use App\Listeners\SendEmailRequestPasswordResetNotification;

use App\Events\PasswordReset;
use App\Listeners\SendEmailPasswordResetNotification;

use App\Events\PasswordChanged;
use App\Listeners\SendEmailPasswordChangedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        RequestEmailVerification::class => [
            SendEmailVerificationNotification::class
        ],
        EmailVerified::class => [
            SendEmailVerifiedNotification::class,
            SetEmailVerified::class,
            RemoveVerificationToken::class
        ],
        RequestPasswordReset::class => [
            SendEmailRequestPasswordResetNotification::class
        ],
        PasswordReset::class => [
            SendEmailPasswordResetNotification::class
        ],
        PasswordChanged::class => [
            SendEmailPasswordChangedNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
