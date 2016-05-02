<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
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
	public function deleteDelete($id)
	{
		if ((Auth::user()->getKey() == $id) || Auth::user()->is_admin) {
			User::withTrashed()->find($id)->deleteAllPrivateData();
		}
		return redirect('home');
	}

	/*
	 * Update profile.
	 */
	public function putPassword(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'id' => 'required|exists:users',
			'password' => 'required|min:6|confirmed',
		]);

		$editorIsAdmin = Auth::user()->is_admin;
		$path = $editorIsAdmin
			? '/admin/show/' . $request->id
			: '/user/settings';

		if ($validator->fails()) {
			return redirect($path)
						->withErrors($validator)
						->withInput();
		}
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
			abort(403, 'Unauthorized action.');
		}

		return redirect($path . '#password');
	}

	/*
	 * Update profile.
	 */
	public function putProfile(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'id' => 'required|exists:users',
			'first_name' => 'required|max:35|regex:/^[(a-zA-Z\s)]+$/u',
			'last_name' => 'required|max:35|regex:/^[(a-zA-Z\s)]+$/u',
			'email' => 'required|email|max:254|unique:users,email,' . $request->id,
			'gender' => 'in:male,female',
			'birthday' => 'required',
		]);

		$editorIsAdmin = Auth::user()->is_admin;
		$path = $editorIsAdmin
			? '/admin/show/' . $request->id
			: '/user/settings';

		if ($validator->fails()) {
			return redirect($path)
						->withErrors($validator)
						->withInput();
		}
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
			abort(403, 'Unauthorized action.');
		}

		$user = User::withTrashed()->find($request->id);
		$user->update([
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
		]);
		$user->save();
		$user->profile->update([
			'date_of_birth' => Carbon::parse($request->birthday)->toDateTimeString(),
			'gender' => $request->gender,
		]);
		$user->profile->save();

		return redirect($path . '#profile');
	}
}
