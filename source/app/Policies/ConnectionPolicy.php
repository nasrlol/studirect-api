<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Connection;
use App\Models\Student;

class ConnectionPolicy
{
    public function viewAny($user): bool
    {
        return $user instanceof Admin;
    }

    public function view($user, Connection $connection): bool
    {
        return $this->isAdmin($user) || $this->hasConnection($user, $connection);
    }

    protected function isAdmin($user): bool
    {
        return $user instanceof Admin;
    }

    protected function hasConnection($user, Connection $connection): bool
    {
        return ($user instanceof Student && $user->id === $connection->student_id)
            || ($user instanceof Company && $user->id === $connection->company_id);
    }

    public function create($user): bool
    {
        return $user instanceof Student || $this->isAdmin($user);
    }

    public function update($user, Connection $connection): bool
    {
        return $this->isAdmin($user) || ($user instanceof Student && $user->id === $connection->student_id);
    }

    public function delete($user, Connection $connection): bool
    {
        return $this->isAdmin($user) || ($user instanceof Student && $user->id === $connection->student_id);
    }

    public function restore($user, Connection $connection): bool
    {
        return false;
    }

    public function forceDelete($user, Connection $connection): bool
    {
        return false;
    }
}
