<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Student;

class AppointmentPolicy
{
    /**
     * Determine whether any user can view all appointments.
     * Only admins are allowed.
     */
    public function viewAny($user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view a specific appointment.
     */
    public function view($user, Appointment $appointment): bool
    {
        return $this->isRelatedToAppointment($user, $appointment) || $this->isAdmin($user);
    }

    protected function isRelatedToAppointment($user, Appointment $appointment): bool
    {
        return $user->id === $appointment->student_id ||
            $user->id === $appointment->company_id;
    }

    protected function isAdmin($user): bool
    {
        return property_exists($user, 'role') && $user->role === 'admin';
    }

    /**
     * Determine whether the user can create an appointment.
     * Only students may create appointments.
     */
    public function create($user): bool
    {
        return $this->isStudent($user);
    }

    protected function isStudent($user): bool
    {
        return get_class($user) === Student::class;
    }

    /**
     * Determine whether the user can update an appointment.
     */
    public function update($user, Appointment $appointment): bool
    {
        return $this->isRelatedToAppointment($user, $appointment) || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete an appointment.
     */
    public function delete($user, Appointment $appointment): bool
    {
        return $this->isRelatedToAppointment($user, $appointment) || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can restore a soft-deleted appointment.
     */
    public function restore($user, Appointment $appointment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete an appointment.
     */
    public function forceDelete($user, Appointment $appointment): bool
    {
        return false;
    }

    protected function isCompany($user): bool
    {
        return get_class($user) === Company::class;
    }
}
