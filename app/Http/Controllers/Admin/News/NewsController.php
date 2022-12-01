<?php

namespace App\Http\Controllers\Admin\News;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
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

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $listNews = $this->news->getListNews(5);

        return view(Constant::FOLDER_URL_ADMIN . '.news.index', compact('listNews'));
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
            $this->news->deleteNews($params);
            $request->session()->flash('alert-success', __('message.MESSAGE_SUCCESS_UPDATE'));
            DB::commit();

            return redirect(route(Constant::FOLDER_URL_ADMIN . '.news.index'));
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert-danger', __('message.TRANSACTION_FAIL'));

            return Redirect::back();
        }
    }
}