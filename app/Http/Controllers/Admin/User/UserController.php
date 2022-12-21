<?php

namespace App\Http\Controllers\Admin\User;

use App\Common\Constant;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\UserRoleRequest;
use App\Models\Admin\Role\Role;
use App\Models\User;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * @var User
     */
    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->middleware('can:' . Constant::GATE_ROLE_IS_ADMIN);
        $this->user = $user;
    }

    /**
     * Display a listing of the users
     *
     * @param User $model
     *
     * @return View
     */
    public function index(User $model)
    {
        $users = $this->user->getAll();

        return view(Constant::FOLDER_URL_ADMIN . '.users.index', compact('users'));
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function editUser(Request $request)
    {
        $id = (int)$request->id;
        $roles = Role::whereNull('deleted_at')->get();
        if ($id) {
            $title = __('Edit User');
        }
        if (empty($id)) {
            $users = $this->user->getAll();

            return view(
                Constant::FOLDER_URL_ADMIN . '.users.index',
                compact('users')
            );
        }

        $getUser = $this->user->getById($id);
        if (empty($getUser)) {
            return redirect()->route(Constant::FOLDER_URL_ADMIN . '.users.index');
        }

        return view(
            Constant::FOLDER_URL_ADMIN . '.users.edit',
            compact('roles', 'getUser', 'title')
        );
    }

    /**
     * @param UserRoleRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(UserRoleRequest $request)
    {
        $params = $request->all();
        $params['userId'] = Auth::id();
        DB::beginTransaction();
        try {
            $this->user->updateUser($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.user.index'));
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert-danger', __('message.TRANSACTION_FAIL'));

            return Redirect::back();
        }
    }
}
