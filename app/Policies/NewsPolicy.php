<?php

namespace App\Policies;

use App\Common\Constant;
use App\Models\Admin\Permission\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
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
     * @param $news
     *
     * @return bool
     */
    public function edit(User $user, $news)
    : bool {
        $permissionList = $this->permission->getAllByRoleId($user->role_id);

        return $permissionList->contains('permission',
                Constant::PERMISSION_UPDATE_NEWS) && $user->id === $news->created_by;
    }

    /**
     * @param User $user
     * @param $news
     *
     * @return bool
     */
    public function delete(User $user, $news)
    : bool {
        $permissionList = $this->permission->getAllByRoleId($user->role_id);

        return $permissionList->contains('permission',
                Constant::PERMISSION_DELETE_NEWS) && $user->id === $news->created_by;
    }
}
