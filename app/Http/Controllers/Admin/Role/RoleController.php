<?php

namespace App\Http\Controllers\Admin\Role;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\RoleRequest;
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

class RoleController extends Controller
{
    /**
     * @param Role $role
     */
    public function __construct(protected Role $role) {
        $this->middleware('auth');
        $this->middleware('can:' . Constant::GATE_ROLE_IS_ADMIN);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $roles = $this->role->getAll();

        return view(Constant::FOLDER_URL_ADMIN . '.role.index', compact('roles'));
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function createAndEdit(Request $request)
    {
        $id = (int)$request->id;
        if ($id) {
            $title = __('Edit Role');
        } else {
            $title = __('Add Role');
        }
        if (empty($id)) {
            return view(
                Constant::FOLDER_URL_ADMIN . '.role.create_edit',
                compact('title')
            );
        }

        $getRole = $this->role->getById($id);
        if (empty($getRole)) {
            return redirect()->route(Constant::FOLDER_URL_ADMIN . '.role.index');
        }

        return view(
            Constant::FOLDER_URL_ADMIN . '.role.create_edit',
            compact('getRole', 'title')
        );
    }

    /**
     * @param RoleRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(RoleRequest $request)
    {
        $params = $request->all();
        $params['userId'] = Auth::id();
        DB::beginTransaction();
        try {
            $this->role->insertOrUpdate($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.role.index'));
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
            $this->role->deleteRole($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.role.index'));
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert-danger', __('message.TRANSACTION_FAIL'));

            return Redirect::back();
        }
    }
}
