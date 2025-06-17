<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Student;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the authenticated user can view the company.
     */
    public function view($user, $id)
    {
        // Companies can only view their own profile
        if ($user instanceof Company) {
            return $user->id == $id;
        }
        
        // Admins can view any company, students can view all companies (handled in routes)
        return $user instanceof Admin || $user instanceof Student;
    }
    
    /**
     * Determine whether the authenticated user can update the company.
     */
    public function update($user, $id)
    {
        // Companies can only update their own profile
        if ($user instanceof Company) {
            return $user->id == $id;
        }
        
        // Only admins can update company profiles
        return $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can delete the company.
     */
    public function delete($user, $id)
    {
        // Companies can delete their own profile
        if ($user instanceof Company) {
            return $user->id == $id;
        }
        
        // Only admins can delete company profiles
        return $user instanceof Admin;
    }
}