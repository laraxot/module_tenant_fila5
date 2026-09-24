<?php

declare(strict_types=1);

namespace Modules\Tenant\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    /**
     * The event handler mappings for the application.
     */
    protected $listen = [];

    /**
     * Indicates if events should be discovered.
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
<<<<<<< .merge_file_Y3lG7a
<<<<<<< HEAD
    protected function configureEmailVerification(): void {}
=======
    protected function configureEmailVerification(): void
    {
    }
>>>>>>> 1ad0554 (.)
=======
    protected function configureEmailVerification(): void
    {
    }
>>>>>>> .merge_file_AE9HmG
}
