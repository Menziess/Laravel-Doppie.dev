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
	public function getIndex()
	{
		return redirect('user/your-profile');
	}

	public function getYourSettings()
	{
		$user = Auth::user();
		$subject = $user;
		return view('content.user.settings', compact('subject', 'user'));
	}

	public function getYourProfile()
	{
		$in = true;
		$user = Auth::user();
		$subject = $user;
		return view('content.user.profile', compact('subject', 'user', 'in'));
	}

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

	public function postPicture(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'file' => 'mimes:jpeg,jpg,png,gif|required|max:500',
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
			$resource->user_id = $user->id;
			$resource->save();
			$user->profile->resource->removeFromStorage();
			$user->profile->resource_id = $resource->getKey();
			$user->profile->save();
		}

		return redirect($path)->with('picture', 'Updated profile picture');
	}

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
