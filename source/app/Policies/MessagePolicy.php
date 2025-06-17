<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\Student;
use App\Models\Company;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the authenticated user can view the message.
     */
    public function view($user, $id)
    {
        $message = Message::find($id);
        
        if (!$message) {
            return false;
        }
        
        // Users can only view messages where they are the sender or receiver
        if ($user instanceof Student || $user instanceof Company) {
            return ($message->sender_id == $user->id && $message->sender_type == get_class($user)) ||
                   ($message->receiver_id == $user->id && $message->receiver_type == get_class($user));
        }
        
        // Admins can view any message
        return $user instanceof Admin;
    }
    
    /**
     * Determine whether the authenticated user can create a new message.
     */
    public function create($user)
    {
        // Any authenticated user can create messages
        return true;
    }
}