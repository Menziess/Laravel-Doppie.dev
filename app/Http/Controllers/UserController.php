<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
	public function getProfile(Request $request)
	{
		return view('auth.user.profile');
	}

	public function getSettings()
	{
		return view('auth.user.settings');
	}
}
