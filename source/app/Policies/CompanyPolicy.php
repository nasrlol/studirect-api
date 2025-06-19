<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Company;

class CompanyPolicy
{
    public function viewAny($user): bool
    {
        return $user instanceof Admin;
    }

    public function view($user, Company $company): bool
    {
        return $this->isSelf($user, $company) || $this->isAdmin($user);
    }

    protected function isSelf($user, Company $company): bool
    {
        return $user instanceof Company && $user->id === $company->id;
    }

    protected function isAdmin($user): bool
    {
        return $user instanceof Admin;
    }

    public function create($user): bool
    {
        return $user instanceof Admin; // Only admins can create companies
    }

    public function update($user, Company $company): bool
    {
        return $this->isSelf($user, $company) || $this->isAdmin($user);
    }

    public function delete($user, Company $company): bool
    {
        return $user instanceof Admin; // Only admins can delete companies
    }

    public function restore($user, Company $company): bool
    {
        return false;
    }

    public function forceDelete($user, Company $company): bool
    {
        return false;
    }
}
