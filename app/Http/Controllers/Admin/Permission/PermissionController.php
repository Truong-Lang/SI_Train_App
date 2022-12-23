<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\Admin\Permission\Permission;
use App\Models\Admin\Role\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    /**
     * @param Permission $permission
     */
    public function __construct(protected Permission $permission)
    {
        $this->middleware('auth');
        $this->middleware('can:' . Constant::GATE_ROLE_IS_ADMIN);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $permissions = $this->permission->getAll();

        return view(Constant::FOLDER_URL_ADMIN . '.permission.index', compact('permissions'));
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function createAndEdit(Request $request)
    {
        $id = (int)$request->id;
        $roles = Role::whereNull('deleted_at')->get();
        if ($id) {
            $title = __('Edit Permission');
        } else {
            $title = __('Add Permission');
        }
        if (empty($id)) {
            return view(
                Constant::FOLDER_URL_ADMIN . '.permission.create_edit',
                compact('roles', 'title')
            );
        }

        $getPermission = $this->permission->getById($id);
        if (empty($getPermission)) {
            return redirect()->route(Constant::FOLDER_URL_ADMIN . '.permission.index');
        }

        return view(
            Constant::FOLDER_URL_ADMIN . '.permission.create_edit',
            compact('roles', 'getPermission', 'title')
        );
    }

    /**
     * @param PermissionRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(PermissionRequest $request)
    {
        $params = $request->all();
        $params['userId'] = Auth::id();
        DB::beginTransaction();
        try {
            $this->permission->insertOrUpdate($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.permission.index'));
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert-danger', __('message.TRANSACTION_FAIL'));

            return Redirect::back();
        }
    }

    /**
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(Request $request)
    {
        $params = $request->all();
        $params['userId'] = Auth::id();
        DB::beginTransaction();
        try {
            $this->permission->deletePermission($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.permission.index'));
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert-danger', __('message.TRANSACTION_FAIL'));

            return Redirect::back();
        }
    }
}
