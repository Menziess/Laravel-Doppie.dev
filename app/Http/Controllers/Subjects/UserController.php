<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Input;
use Auth;
use App\User;
use App\Resource;
use App\Http\Requests;

class UserController extends Controller
{
	/*
	 * Redirect to own profile.
	 */
	public function getIndex()
	{
		return redirect('user/your-profile');
	}

	/*
	 * Get own settings.
	 */
	public function getYourSettings()
	{
		$subject = Auth::user();
		return view('content.user.settings', compact('links', 'subject'));
	}

	/*
	 * Get own profile.
	 */
	public function getYourProfile()
	{
		$subject = Auth::user();
		return view('content.user.profile', compact('links', 'subject'));
	}

	/*
	 * Get some profile by id.
 	 */
	public function getProfile($id)
	{
		# Check if user is visiting own profile
		if (Auth::user()->id == $id) {
			return redirect('user/your-profile');
		} else if (Auth::user()->is_admin) {
			return redirect('admin/user/' . $id);
		}

		$user = User::findOrFail($id);
		$subject = $user;
		return view('content.user.profile', compact('subject', 'user'));
	}

	/*
	 * Post a new profile picture.
	 */
	public function postPicture(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'file' => 'required|mimes:jpeg,jpg,png,gif|max:4000',
		]);

		$editorIsAdmin = Auth::user()->is_admin;
		$path = $editorIsAdmin
			? '/admin/user-settings/' . $request->id . '#picture'
			: '/user/your-settings' . '#picture';

		if ($validator->fails()) {
			return redirect($path)->withErrors($validator);
		}
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
			abort(403);
		}

		$resource = new Resource;
		$filepath = $resource->uploadImageFile($request->file('file'), 522, 522);
		$user = User::withTrashed()->find($request->id);

		# Persist if uploaded succesfully
		if (\Storage::exists($filepath)) {
			if ($user->profile->resource) {
				$user->profile->resource->removeFromStorage();
			}
			$resource->user_id = $user->id;
			$resource->save();
			$user->profile->resource_id = $resource->getKey();
			$user->profile->save();
		}

		return redirect($path)->with('picture', 'Updated profile picture');
	}

	/*
	 * Update password.
	 */
	public function putPassword(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'id' => 'required|exists:users',
			'password' => 'required|min:6|confirmed',
		]);

		$editorIsAdmin = Auth::user()->is_admin;
		$path = $editorIsAdmin
			? '/admin/user-settings/' . $request->id . '#password'
			: '/user/your-settings' . '#password';

		if ($validator->fails()) {
			return redirect($path)->withErrors($validator);
		}
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
			abort(403);
		}
		$user = User::withTrashed()->find($request->id);
		$user->password = bcrypt($request->password);
		$user->save();

		return redirect($path)->with('password', 'Password set');
	}

	/*
	 * Update profile information.
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
			? '/admin/user-settings/' . $request->id . '#profile'
			: '/user/your-settings' . '#profile';

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

	/*
	 * Delete user.
	 */
	public function deleteDelete($id)
	{
		$editorIsAdmin = Auth::user()->is_admin;
		if (!$editorIsAdmin && !Auth::user()->id == $id) {
			abort(403);
		}

		$fail = $editorIsAdmin
			? '/admin/user-settings/'. $id . '#delete'
			: '/user/your-settings' . '#delete';
		$success = $editorIsAdmin
			? '/admin' . '#users'
			: '/user/your-settings';

		$user = User::withTrashed()->findOrFail($id);

		$message = 'User "' . $user->getName() . '" deleted';
		$error = $user->deleteAllPrivateData();

		$error
			? $redirect = redirect($fail)->withErrors(['user' => $error])
			: $redirect = redirect($success)->with('user', $message);

		return $redirect;
	}
}
