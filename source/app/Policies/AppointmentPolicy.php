<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Student;
use App\Models\Company;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the authenticated user can view the appointment.
     */
    public function view($user, $id)
    {
        $appointment = Appointment::find($id);
        
        if (!$appointment) {
            return false;
        }
        
        // Students can only view their own appointments
        if ($user instanceof Student) {
            return $user->id == $appointment->student_id;
        }
        
        // Companies can only view their own appointments
        if ($user instanceof Company) {
            return $user->id == $appointment->company_id;
        }
        
        // Admins can view any appointment
        return $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can update the appointment.
     */
    public function update($user, $id)
    {
        $appointment = Appointment::find($id);
        
        if (!$appointment) {
            return false;
        }
        
        // Students can update their own appointments
        if ($user instanceof Student) {
            return $user->id == $appointment->student_id;
        }
        
        // Companies can update their own appointments
        if ($user instanceof Company) {
            return $user->id == $appointment->company_id;
        }
        
        // Admins can update any appointment
        return $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can delete the appointment.
     */
    public function delete($user, $id)
    {
        $appointment = Appointment::find($id);
        
        if (!$appointment) {
            return false;
        }
        
        // Students can delete their own appointments
        if ($user instanceof Student) {
            return $user->id == $appointment->student_id;
        }
        
        // Companies can delete their own appointments
        if ($user instanceof Company) {
            return $user->id == $appointment->company_id;
        }
        
        // Admins can delete any appointment
        return $user instanceof Admin;
    }
}