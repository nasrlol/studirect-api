<?php

namespace App\Providers;

use App\Models\Student;
use App\Models\Company;
use App\Models\Appointment;
use App\Models\Connection;
use App\Models\Message;
use App\Policies\StudentPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\AppointmentPolicy;
use App\Policies\ConnectionPolicy;
use App\Policies\MessagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Student::class => StudentPolicy::class,
        Company::class => CompanyPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        Connection::class => ConnectionPolicy::class,
        Message::class => MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}