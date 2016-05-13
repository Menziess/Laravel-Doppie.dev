<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Project;
use App\Http\Requests;

class ProjectController extends Controller
{
	public function getIndex()
	{
		return 'Make new project';
	}

	public function postIndex()
	{

	}

	public function getProfile($id)
	{
		$in = true;
		$project = Project::findOrFail($id);
		$subject = $project;
		return view('content.project.profile', compact('subject', 'project', 'in'));
	}

	public function deleteDelete($id)
	{
		if (Auth::user()->is_admin) {
			$project = Project::withTrashed()->find($id);
			if ($project) {
				$project->deleteAllPrivateData();
			}
		}
		return redirect('admin');
	}
}
