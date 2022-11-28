<?php

namespace App\Http\Controllers\Admin\News;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\Admin\Category\Category;
use App\Models\Admin\News\News;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NewsController extends Controller
{
    /**
     * @var News
     */
    protected News $news;

    /**
     * NewsController constructor.
     *
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->middleware('auth');
        $this->news = $news;
    }

    public function index()
    {
        $listNews = $this->news->getAll();
        return view(Constant::FOLDER_URL_ADMIN.'.news.index', compact('listNews'));
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function createAndEdit(Request $request)
    {
        $id = (int)$request->id;
        $listNews = $this->news->getAll();
        $categories = Category::all();
        if ($id) {
            $title = __('Edit News');
        } else {
            $title = __('Add News');
        }
        if (empty($id)) {
            return view(
                Constant::FOLDER_URL_ADMIN . '.news.create_edit',
                compact('listNews', 'categories', 'title')
            );
        }

        $getNews = $this->news->getById($id);
        if (empty($getNews)) {
            return redirect()->route(Constant::FOLDER_URL_ADMIN . '.news.index', [$categories]);
        }


        return view(
            Constant::FOLDER_URL_ADMIN . '.news.create_edit',
            compact('listNews', 'getNews', 'categories', 'title')
        );
    }

    /**
     * @param NewsRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(NewsRequest $request)
    {
        $params = $request->all();
        $params['userId'] = Auth::id();
        DB::beginTransaction();
        try {
            $id = $this->news->insertOrUpdate($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            $backUrl = route(Constant::FOLDER_URL_ADMIN . '.news.createAndEdit') . '/' . $params['id'];
            if (empty($params['id'])) {
                $backUrl = route(Constant::FOLDER_URL_ADMIN . '.news.createAndEdit') . '/' . $id;
            }
            return redirect($backUrl);
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert-danger', __('message.TRANSACTION_FAIL'));

            return Redirect::back();
        }
    }
}
