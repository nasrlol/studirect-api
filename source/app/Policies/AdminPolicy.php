namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
public function viewAny(Admin $user): bool
{
return true;
}

public function view(Admin $user, Admin $admin): bool
{
return true;
}

public function create(Admin $user): bool
{
return true;
}

public function update(Admin $user, Admin $admin): bool
{
return true;
}

public function delete(Admin $user, Admin $admin): bool
{
return true;
}

public function restore(Admin $user, Admin $admin): bool
{
return false;
}

public function forceDelete(Admin $user, Admin $admin): bool
{
return false;
}
}
