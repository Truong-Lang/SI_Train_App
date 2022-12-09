<?php

namespace App\Http\Controllers\FrontEnd\News;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Models\FrontEnd\Category\Category;
use App\Models\FrontEnd\News\News;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @var News
     */
    protected News $news;

    /**
     * @var Category
     */
    protected Category $category;

    /**
     * @param News $news
     * @param Category $category
     */
    public function __construct(News $news, Category $category)
    {
        $this->news = $news;
        $this->category = $category;
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $categoryAlias = (string)$request->categoryAlias;
        $listCategories = $this->category->getAll();
        $category = $this->category->getByAlias($categoryAlias);
        $listNews = $category ? $this->news->getAllByCategoryId($category->id) : '';

        return view(Constant::FOLDER_URL_FRONTEND . '.news.index', compact('listCategories', 'category', 'listNews'));
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function getDataNewsDetail(Request $request)
    {
        $categoryAlias = (string)$request->categoryAlias;
        $newsAlias = (string)$request->newsAlias;
        $category = $this->category->getByAlias($categoryAlias);
        if (empty($category)) {
            return redirect()->route(Constant::FOLDER_URL_FRONTEND . '.news.index');
        }

        $listNews = $this->news->getAllByCategoryId($category->id);
        $listCategories = $this->category->getAll();
        $getNews = $this->news->getByAlias($newsAlias);
        if (empty($getNews)) {
            return redirect()->route(Constant::FOLDER_URL_FRONTEND . '.news.index', [$categoryAlias]);
        }

        return view(Constant::FOLDER_URL_FRONTEND . '.news.detail',
            compact('newsAlias', 'category', 'listNews', 'listCategories', 'getNews'));
    }
}