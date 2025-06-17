<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\Company;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the authenticated user can view the student.
     */
    public function view($user, $id)
    {
        // Students can only view their own profile
        if ($user instanceof Student) {
            return $user->id == $id;
        }
        
        // Companies and admins can view any student
        return $user instanceof Company || $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can update the student.
     */
    public function update($user, $id)
    {
        // Students can only update their own profile
        if ($user instanceof Student) {
            return $user->id == $id;
        }
        
        // Only admins can update other student profiles
        return $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can delete the student.
     */
    public function delete($user, $id)
    {
        // Students can delete their own profile
        if ($user instanceof Student) {
            return $user->id == $id;
        }
        
        // Only admins can delete student profiles
        return $user instanceof Admin;
    }
}