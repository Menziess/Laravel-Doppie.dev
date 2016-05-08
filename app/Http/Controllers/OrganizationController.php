<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Organization;
use App\Http\Requests;

class OrganizationController extends Controller
{
    /*
	 * Hard deletes a organization and all its data.
	 */
	public function deleteDelete($id)
	{
		if (Auth::user()->is_admin) {
			$organization = Organization::withTrashed()->find($id);
			if ($organization) {
				$organization->deleteAllPrivateData();
			}
		}
		return redirect('admin/users');
	}
}
