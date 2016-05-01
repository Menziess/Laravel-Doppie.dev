<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Http\Requests;

class AdminController extends Controller
{
	public function getIndex(Request $request)
	{
		if (!\Auth::user()->is_admin) {
			return redirect('home');
		}

		$users = User::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('auth.admin.users', compact('users'));
	}

	public function getShow($id)
	{
		$user = User::withTrashed()->find($id);
		if (!$user || !Auth::user()->is_admin) {
			return redirect('home');
		}
		return view('auth.user.profile', compact('user'));
	}

	/*
	 * Soft deletes user and sets is_active on false.
	 */
	public function getMakeadmin($id)
	{
		if (Auth::user()->is_admin) {
			$user = User::withTrashed()->find($id);
			$user->is_admin = true;
			$user->save();
		}
		return redirect()->back();
	}

	/*
	 * Restores a user and sets is_active on true.
	 */
	public function getActivate($id)
	{
		if (Auth::user()->is_admin) {
			User::withTrashed()->find($id)->activate();
		}
		return redirect()->back();
	}

	/*
	 * Soft deletes user and sets is_active on false.
	 */
	public function getDeactivate($id)
	{
		if (Auth::user()->is_admin) {
			User::withTrashed()->find($id)->deactivate();
		}
		return redirect()->back();
	}
}
