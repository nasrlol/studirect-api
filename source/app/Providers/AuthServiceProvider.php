<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Company;
use App\Models\Connection;
use App\Models\Student;
use App\Policies\AdminPolicy;
use App\Policies\AppointmentPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\ConnectionPolicy;
use App\Policies\StudentPolicy;
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
        Connection::class => ConnectionPolicy::class,
        Student::class => StudentPolicy::class,
        Company::class => CompanyPolicy::class,
        Admin::class => AdminPolicy::class,
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
