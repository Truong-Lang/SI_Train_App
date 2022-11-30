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

    /**
     * @return Application|Factory|View
     */
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
        $categories = Category::all();
        if ($id) {
            $title = __('Edit News');
        } else {
            $title = __('Add News');
        }
        if (empty($id)) {
            return view(
                Constant::FOLDER_URL_ADMIN . '.news.create_edit',
                compact('categories', 'title')
            );
        }

        $getNews = $this->news->getById($id);
        if (empty($getNews)) {
            return redirect()->route(Constant::FOLDER_URL_ADMIN . '.news.index');
        }

        return view(
            Constant::FOLDER_URL_ADMIN . '.news.create_edit',
            compact('getNews', 'categories', 'title')
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

            // Logic upload image
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = Constant::NEWS_IMAGES_FOLDER . '/' . $id;
                $old_file = '';
                if (!empty($params['id']) && !empty($params['image_path'])) {
                    $old_file = $params['image_path'];
                }
                $params['image'] = $this->uploadImageService->uploadImage($file, $path, $old_file);
                if (empty($params['id'])) {
                    $params['id'] = $id;
                }
                $this->news->updatePathImageNews($params);
            }

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