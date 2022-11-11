<?php

namespace App\Http\Controllers\Admin\Category;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Admin\Category\Category;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * @var Category
     */
    protected Category $category;

    /**
     * CategoryController constructor.
     *
     *
     */
    public function __construct(Category $category)
    {
        $this->middleware('auth');
        $this->category = $category;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $listParent = $this->category->getAll(['c.parent' => Constant::NUMBER_ZERO], 'c.status ASC');

        return view(Constant::FOLDER_URL_ADMIN . '.category.index', compact('listParent'));
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function createAndEdit(Request $request)
    {
        $id = (int)$request->id;
        $listParent = $this->category->getAll();
        if ($id) {
            $title = __('Edit Category');
        } else {
            $title = __('Add Category');
        }
        if (empty($id)) {
            return view(
                Constant::FOLDER_URL_ADMIN . '.category.create_edit',
                compact('listParent', 'title')
            );
        }

        $getCategory = $this->category->getById($id);
        if (empty($getCategory)) {
            return redirect()->route(Constant::FOLDER_URL_ADMIN . '.category.index');
        }


        return view(
            Constant::FOLDER_URL_ADMIN . '.category.create_edit',
            compact('listParent', 'getCategory', 'title')
        );
    }

    /**
     * @param CategoryRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CategoryRequest $request)
    {
        $params = $request->all();
        $params['userId'] = Auth::id();
        DB::beginTransaction();
        try {
            $this->category->insertOrUpdate($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.category.index'));
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
            $this->category->deleteCategory($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.category.index'));
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert-danger', __('message.TRANSACTION_FAIL'));

            return Redirect::back();
        }
    }
}