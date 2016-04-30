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

	public function getShow($id)
	{
		if ($id && Auth::user()->is_admin) {
			$user = User::find($id);
		} else {
			return redirect('home');
		}
		return view('auth.user.profile', compact('user'));
	}
}
