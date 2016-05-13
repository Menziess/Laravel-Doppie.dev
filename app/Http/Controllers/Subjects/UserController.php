<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Auth;
use App\User;
use App\Http\Requests;

class UserController extends Controller
{
	# Get profile
	public function getIndex()
	{
		return redirect('user/profile');
	}

	# Get settings
	public function getYourSettings()
	{
		$user = Auth::user();
		$subject = $user;
		return view('content.user.settings', compact('subject', 'user'));
	}

	# Get profile
	public function getYourProfile()
	{
		$in = true;
		$user = Auth::user();
		$subject = $user;
		return view('content.user.profile', compact('subject', 'user', 'in'));
	}

	# Get profile
	public function getProfile($id)
	{
		# Check if user is visiting own profile
		if (Auth::user()->id == $id) {
			redirect('user/profile');
		}

		$in = true;
		$user = User::findOrFail($id);
		$subject = $user;
		return view('content.user.profile', compact('subject', 'user', 'in'));
	}

	# Update password
	public function putPassword(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'id' => 'required|exists:users',
			'password' => 'required|min:6|confirmed',
		]);

		$editorIsAdmin = Auth::user()->is_admin;
		$path = $editorIsAdmin
			? '/admin/user-settings/' . $request->id . '#password'
			: '/user/settings' . '#password';

		if ($validator->fails()) {
			return redirect($path)
					->withErrors($validator);
		}
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
			abort(403);
		}
		$user = User::withTrashed()->find($request->id);
		$user->password = bcrypt($request->password);
		$user->save();

		return redirect($path)
				->with('password', 'Password set');
	}

	# Update profile
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
			? '/admin/user-settings/' . $request->id . '#profile'
			: '/user/settings' . '#profile';

		if ($validator->fails()) {
			return redirect($path)
					->withErrors($validator)
					->withInput();
		}
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
			abort(403);
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

	# Hard delete user and related data
	public function deleteDelete($id)
	{
		if ((Auth::user()->getKey() == $id) || Auth::user()->is_admin) {
			$user = User::withTrashed()->find($id);
			if ($user) {
				$user->deleteAllPrivateData();
			}
		}
		return redirect('admin');
	}
}
