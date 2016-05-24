<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Organization;
use App\Http\Requests;

class OrganizationController extends Controller
{
	/*
	 * Get organization creation form.
	 */
	public function getIndex()
	{
		return 'Make new organization';
	}

	/*
	 * Post organization creation form.
	 */
	public function postIndex()
	{

	}

	/*
	 * Get the organizations profile by id.
	 */
	public function getProfile($id)
	{
		$subject = Organization::findOrFail($id);
		$links = [];
		return view('content.organization.profile', compact('subject'));
	}

	/*
	 * Get the organizations profile by id.
	 */
	public function getSettings($id)
	{
		$subject = Organization::findOrFail($id);
		$links = [];
		return view('content.organization.settings', compact('subject'));
	}

	/*
	 * Delete organization.
	 */
	public function deleteDelete($id)
	{
		$editorIsAdmin = Auth::user()->is_admin;
		if (!$editorIsAdmin) {
			abort(403);
		}

		$fail = $editorIsAdmin
			? '/admin/organization-settings/'. $id . '#delete'
			: '/organization/settings' . '#delete';
		$success = $editorIsAdmin
			? '/admin' . '#organizations'
			: '/user/your-profile';

		$organization = Organization::withTrashed()->findOrFail($id);

		$message = 'Organization "' . $organization->getName() . '" deleted';
		$error = $organization->deleteAllPrivateData();

		$error
			? $redirect = redirect($fail)->withErrors(['organization' => $error])
			: $redirect = redirect($success)->with('organization', $message);

		return $redirect;
	}
}
