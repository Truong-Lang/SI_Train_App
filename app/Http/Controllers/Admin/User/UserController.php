<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param User $model
     *
     * @return View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }
}
