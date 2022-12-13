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
        $listNews = $this->news->getAll([['c.alias', $categoryAlias]]);

        return view(Constant::FOLDER_URL_FRONTEND . '.news.index', compact('categoryAlias', 'listNews'));
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
        $getNews = $this->news->getAll([['n.alias', $newsAlias], ['c.alias', $categoryAlias]], true);
        if (empty($getNews)) {
            return redirect()->route(Constant::FOLDER_URL_FRONTEND . '.news.index', [$categoryAlias]);
        }

        $listNews = $this->news->getAll([['c.alias', $categoryAlias]]);

        return view(Constant::FOLDER_URL_FRONTEND . '.news.detail',
            compact('categoryAlias', 'newsAlias', 'getNews', 'listNews'));
    }
}