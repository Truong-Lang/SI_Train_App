<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Common\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return View
     */
    public function edit()
    {
        return view(Constant::FOLDER_URL_ADMIN . '.profile.edit');
    }

    /**
     * Update the profile
     *
     * @param ProfileRequest $request
     *
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param PasswordRequest $request
     *
     * @return RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }
}
