<?php

namespace App\Policies;

use App\Common\Constant;
use App\Models\Admin\Permission\Permission;
use App\Models\Admin\Role\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $ability
     *
     * @return bool|void
     */
    public function before(User $user, $ability)
    {
        $role = new Role();
        $role_name = $role->getByUserId($user->id)->name;
        if ($role_name === Constant::ROLE_ADMIN) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param $category
     *
     * @return bool
     */
    public function edit(User $user, $category)
    {
        $permission = new Permission();
        $permissionList = $permission->getAllByRoleId($user->role_id);
        if ($permissionList->contains('permission',
                Constant::PERMISSION_UPDATE_CATEGORY) && $user->id === $category->created_by) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param User $user
     * @param $category
     *
     * @return bool
     */
    public function delete(User $user, $category)
    {
        $permission = new Permission();
        $permissionList = $permission->getAllByRoleId($user->role_id);
        if ($permissionList->contains('permission',
                Constant::PERMISSION_DELETE_CATEGORY) && $user->id === $category->created_by) {
            return true;
        } else {
            return false;
        }
    }
}
