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
		$users = User::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('auth.admin.users', compact('users'));
	}

	public function getShow($id)
	{
		$user = User::withTrashed()->find($id);
		if (!$user) {
			return redirect('home');
		}
		return view('auth.user.settings', compact('user'));
	}

	/*
	 * Soft deletes user and sets is_active on false.
	 */
	public function getToggleadmin($id)
	{
		$user = User::withTrashed()->find($id);
		$user->makeAdmin();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Restores a user and sets is_active on true.
	 */
	public function getActivate($id)
	{
		User::withTrashed()->find($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Soft deletes user and sets is_active on false.
	 */
	public function getDeactivate($id)
	{
		User::withTrashed()->find($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}
}
