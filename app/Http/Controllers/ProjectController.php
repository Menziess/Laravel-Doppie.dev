<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Project;
use App\Http\Requests;

class ProjectController extends Controller
{
    /*
	 * Hard deletes a project and all its data.
	 */
	public function deleteDelete($id)
	{
		if (Auth::user()->is_admin) {
			$project = Project::withTrashed()->find($id);
			if ($project) {
				$project->deleteAllPrivateData();
			}
		}
		return redirect('admin/users');
	}
}
