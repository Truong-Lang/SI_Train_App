<?php

namespace App\Http\Controllers\Admin\News;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Services\UploadImage\UploadImageService;
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
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * @var News
     */
    protected News $news;

    /**
     * @var UploadImageService
     */
    protected UploadImageService $uploadImageService;

    /**
     * NewsController constructor.
     *
     * @param News $news
     * @param UploadImageService $uploadImageService
     */
    public function __construct(News $news, UploadImageService $uploadImageService)
    {
        $this->middleware('auth');
        $this->news = $news;
        $this->uploadImageService = $uploadImageService;
    }

    public function index()
    {
        $listNews = $this->news->getAll();

        return view(Constant::FOLDER_URL_ADMIN . '.news.index', compact('listNews'));
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
            return redirect()->route(Constant::FOLDER_URL_ADMIN . '.news.index');
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
        $file = $request->file('image');
        DB::beginTransaction();
        try {
            if (empty($params['id'])) {
                $params['id'] = $this->news->insertOrUpdate($params);
            }
            $path = Constant::NEWS_IMAGES_FOLDER . '/' . $params['id'];
            $params['old_files'] = Storage::files($path);

            $params['image'] = $this->uploadImageService->uploadImage($file, $path);
            $this->news->insertOrUpdate($params);

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
