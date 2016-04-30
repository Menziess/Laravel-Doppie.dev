<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Http\Requests;

class UserController extends Controller
{
	public function getProfile()
	{
		$user = Auth::user();
		return view('auth.user.profile', compact('user'));
	}

	public function getSettings()
	{
		$user = Auth::user();
		return view('auth.user.settings', compact('user'));
	}

	/*
	 * Hard deletes a user and all its data.
	 */
	public function getDelete($id)
	{
		if ((Auth::user()->getKey() == $id) || Auth::user()->is_admin) {
			User::find($id)->deleteAllPrivateData();
		}
		return redirect()->back();
	}
}
