<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Log;

class LogPolicy
{
    public function viewAny($user): bool
    {
        return $user instanceof Admin;
    }

    public function view($user, Log $log): bool
    {
        return $user instanceof Admin;
    }

    public function create($user): bool
    {
        return $user instanceof Admin;
    }

    public function update($user, Log $log): bool
    {
        return $user instanceof Admin;
    }

    public function delete($user, Log $log): bool
    {
        return $user instanceof Admin;
    }
}
