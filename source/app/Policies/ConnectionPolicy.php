<?php

namespace App\Policies;

use App\Models\Connection;
use App\Models\Student;
use App\Models\Company;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConnectionPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the authenticated user can view the connection.
     */
    public function view($user, $id)
    {
        $connection = Connection::find($id);
        
        if (!$connection) {
            return false;
        }
        
        // Students can only view their own connections
        if ($user instanceof Student) {
            return $user->id == $connection->student_id;
        }
        
        // Companies can only view their own connections
        if ($user instanceof Company) {
            return $user->id == $connection->company_id;
        }
        
        // Admins can view any connection
        return $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can update the connection.
     */
    public function update($user, $id)
    {
        $connection = Connection::find($id);
        
        if (!$connection) {
            return false;
        }
        
        // Students can update their own connections
        if ($user instanceof Student) {
            return $user->id == $connection->student_id;
        }
        
        // Companies can update their own connections
        if ($user instanceof Company) {
            return $user->id == $connection->company_id;
        }
        
        // Admins can update any connection
        return $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can delete the connection.
     */
    public function delete($user, $id)
    {
        $connection = Connection::find($id);
        
        if (!$connection) {
            return false;
        }
        
        // Students can delete their own connections
        if ($user instanceof Student) {
            return $user->id == $connection->student_id;
        }
        
        // Companies can delete their own connections
        if ($user instanceof Company) {
            return $user->id == $connection->company_id;
        }
        
        // Admins can delete any connection
        return $user instanceof Admin;
    }
}