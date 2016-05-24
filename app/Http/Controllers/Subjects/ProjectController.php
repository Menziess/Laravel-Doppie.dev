<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Project;
use App\Http\Requests;

class ProjectController extends Controller
{
	/*
	 * Get project creation form.
	 */
	public function getIndex()
	{
		return 'Make new project';
	}

	/*
	 * Post project creation form.
	 */
	public function postIndex()
	{

	}

	/*
	 * Get project profile by id.
	 */
	public function getProfile($id)
	{
		$subject = Project::findOrFail($id);
		$links = [];
		return view('content.project.profile', compact('links', 'subject'));
	}

	/*
	 * Get project profile by id.
	 */
	public function getSettings($id)
	{
		$subject = Project::findOrFail($id);
		$links = [];
		return view('content.project.settings', compact('links', 'subject'));
	}

	/*
	 * Delete project.
	 */
	public function deleteDelete($id)
	{
		$editorIsAdmin = Auth::user()->is_admin;
		if (!$editorIsAdmin) {
			abort(403);
		}

		$fail = $editorIsAdmin
			? '/admin/project-settings/'. $id . '#delete'
			: '/project/settings' . '#delete';
		$success = $editorIsAdmin
			? '/admin' . '#projects'
			: '/user/your-profile';

		$project = Project::withTrashed()->findOrFail($id);

		$message = 'Project "' . $project->getName() . '" deleted';
		$error = $project->deleteAllPrivateData();

		$error
			? $redirect = redirect($fail)->withErrors(['project' => $error])
			: $redirect = redirect($success)->with('project', $message);

		return $redirect;
	}
}
