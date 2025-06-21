<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Company;
use App\Models\Student;

class AppointmentPolicy
{
    public function create($user): bool
    {
        return $this->isStudent($user);
    }

    protected function isStudent($user): bool
    {
        return $user instanceof Student;
    }

    public function viewAny($user): bool
    {
        return $this->isAdmin($user);
    }

    protected function isAdmin($user): bool
    {
        return $user instanceof Admin;
    }

    public function view($user, Appointment $appointment): bool
    {
        return $this->isRelatedToAppointment($user, $appointment) || $this->isAdmin($user);
    }

    protected function isRelatedToAppointment($user, Appointment $appointment): bool
    {
        return $user->id === $appointment->student_id ||
            $user->id === $appointment->company_id;
    }

    public function update($user, Appointment $appointment): bool
    {
        return $this->isRelatedToAppointment($user, $appointment) || $this->isAdmin($user);
    }

    public function delete($user, Appointment $appointment): bool
    {
        return $this->isRelatedToAppointment($user, $appointment) || $this->isAdmin($user);
    }

    public function restore($user, Appointment $appointment): bool
    {
        return false;
    }

    public function forceDelete($user, Appointment $appointment): bool
    {
        return false;
    }

    protected function isCompany($user): bool
    {
        return $user instanceof Company;
    }
}
