<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use Illuminate\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view(Constant::FOLDER_URL_ADMIN . '.dashboard');
    }
}
