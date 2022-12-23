<?php

namespace App\Policies;

use App\Common\Constant;
use App\Models\Admin\Permission\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * @param Permission $permission
     */
    public function __construct(
        protected Permission $permission
    ) {
    }

    /**
     * @param User $user
     * @param $ability
     *
     * @return bool|void
     */
    public function before(User $user, $ability)
    {
        if ($user->role_id === Constant::ROLE['Admin']) {
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
    : bool {
        $permissionList = $this->permission->getAllByRoleId($user->role_id);

        return $permissionList->contains('permission',
                Constant::PERMISSION_UPDATE_CATEGORY) && $user->id === $category->created_by;
    }

    /**
     * @param User $user
     * @param $category
     *
     * @return bool
     */
    public function delete(User $user, $category)
    : bool {
        $permissionList = $this->permission->getAllByRoleId($user->role_id);

        return $permissionList->contains('permission',
                Constant::PERMISSION_DELETE_CATEGORY) && $user->id === $category->created_by;
    }
}
