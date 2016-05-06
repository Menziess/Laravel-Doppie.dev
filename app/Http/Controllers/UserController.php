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
		return 'Profile';
	}

	public function getSettings()
	{
		$user = Auth::user();
		return view('content.user.settings', compact('user'));
	}

	/*
	 * Hard deletes a user and all its data.
	 */
	public function deleteDelete($id)
	{
		if ((Auth::user()->getKey() == $id) || Auth::user()->is_admin) {
			User::withTrashed()->find($id)->deleteAllPrivateData();
		}
		return redirect('admin');
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
			? '/admin/user/' . $request->id . '#password'
			: '/user/settings' . '#password';

		if ($validator->fails()) {
			return redirect($path)
					->withErrors($validator);
		}
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
			abort(403, 'Unauthorized action.');
		}
		$user = User::withTrashed()->find($request->id);
		$user->password = bcrypt($request->password);
		$user->save();

		return redirect($path)
				->with('password', 'Password set');
	}

	/*
	 * Update profile.
	 */
	public function putProfile(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'id' => 'required|exists:users',
			'first_name' => 'required|max:35|regex:/^[(a-zA-Z\s-)]+$/u',
			'last_name' => 'required|max:35|regex:/^[(a-zA-Z\s-)]+$/u',
			'email' => 'required|email|max:254|unique:users,email,' . $request->id,
			'gender' => 'in:male,female',
		]);

		$editorIsAdmin = Auth::user()->is_admin;
		$path = $editorIsAdmin
			? '/admin/user/' . $request->id . '#profile'
			: '/user/settings' . '#profile';

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
		$user->profile->update([
			# 'date_of_birth' => Carbon::parse($request->birthday)->toDateTimeString(), // not required
			'gender' => $request->gender,
			# 'latitude' => $request->latitude,		// not allowed yet
			# 'longitude' => $request->longitude, 	// not allowed yet
		]);

		return redirect($path)->with('profile', 'Profile updated');
	}
}
