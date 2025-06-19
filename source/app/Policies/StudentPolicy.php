<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Student;

class StudentPolicy
{
    public function viewAny($user): bool
    {
        return $user instanceof Admin || $user instanceof Company;
    }

    public function view($user, Student $student): bool
    {
        return $this->isAdmin($user)
            || ($user instanceof Company)
            || ($user instanceof Student && $user->id === $student->id);
    }

    protected function isAdmin($user): bool
    {
        return $user instanceof Admin;
    }

    public function create($user): bool
    {
        return $user instanceof Admin || $user instanceof Student;
    }

    public function update($user, Student $student): bool
    {
        return $this->isAdmin($user) || ($user instanceof Student && $user->id === $student->id);
    }

    public function delete($user, Student $student): bool
    {
        return $this->isAdmin($user) || ($user instanceof Student && $user->id === $student->id);
    }

    public function restore($user, Student $student): bool
    {
        return false;
    }

    public function forceDelete($user, Student $student): bool
    {
        return false;
    }
}
