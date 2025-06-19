<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Policies\AppointmentPolicy;
use Illuminate\Support\ServiceProvider;

// models

// policies


/**
 * Class AuthServiceProvider
 *
 * This service provider is responsible for registering authentication services.
 */
class AuthServiceProvider extends ServiceProvider
{
    protected array $policies = [
        Appointment::class => AppointmentPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    public function boot(): void
    {

    }
}
