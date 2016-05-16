<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Organization;
use App\Http\Requests;

class OrganizationController extends Controller
{
	public function getIndex()
	{
		return 'Make new organization';
	}

	public function postIndex()
	{

	}

	public function getProfile($id)
	{
		$subject = Organization::findOrFail($id);
		return view('content.organization.profile', compact('subject'));
	}

	public function deleteDelete($id)
	{
		$editorIsAdmin = Auth::user()->is_admin;
		if (!$editorIsAdmin && !Auth::user()->id == $request->id) {
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
