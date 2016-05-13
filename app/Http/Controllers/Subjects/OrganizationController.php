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
		$in = true;
		$organization = Organization::findOrFail($id);
		$subject = $organization;
		return view('content.organization.profile', compact('subject', 'organization', 'in'));
	}

	public function deleteDelete($id)
	{
		if (Auth::user()->is_admin) {
			$organization = Organization::withTrashed()->find($id);
			if ($organization) {
				$organization->deleteAllPrivateData();
			}
		}
		return redirect('admin');
	}
}
