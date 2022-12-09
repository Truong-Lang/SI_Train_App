<?php

namespace App\Http\Controllers\FrontEnd;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Category\Category;
use App\Models\Admin\News\News;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    public function index(Request $request)
    {
        $categoryAlias = (string)$request->categoryAlias;
        $newsAlias = (string)$request->newsAlias;
        $listCategories = $this->category->getAll();
        $listNews = $this->news->getAllByCategory([['c.alias', '=', $categoryAlias]]);
        $category = $this->category->getByAlias($categoryAlias);

        if (empty($newsAlias)) {
            return view('home.index', compact('listCategories', 'listNews', 'category'));
        }

        $getNews = $this->news->getByAlias($newsAlias);
        if (empty($getNews)) {
            return redirect()->route(Constant::FOLDER_URL_HOME . '.index');
        }

        return view('home.index', compact('newsAlias', 'listCategories', 'getNews', 'listNews', 'category'));
    }
}