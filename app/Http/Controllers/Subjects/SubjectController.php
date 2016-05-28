<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Project;
use App\Organization;
use App\Http\Requests;

class SubjectController extends Controller
{
    const SUBJECTS = [
		// ['title' => 'Users', 'href' => 'subject/users', 'text' => ''],
		// ['title' => 'Projects', 'href' => 'subject/projects', 'text' => ''],
		// ['title' => 'Organizations', 'href' => 'subject/organizations', 'text' => ''],
	];

	/*
	 * Get a overview of all subjects.
	 */
	public function getIndex(Request $request)
	{
		$input = $request->search;
		$search = '%' . $input . '%' ?: '%';
		$subject = Auth::user();
		$users = User::where('first_name', 'like', $search)
			->orWhere('last_name', 'like', $search)
			->orWhere('email', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		$projects = Project::where('name', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		$organizations = Organization::where('name', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		return view('content.subject.list', compact('users', 'projects', 'organizations', 'subject', 'input'));
	}

	/*
	 * Get all users.
	 */
	public function getUsers()
	{
		$subject = Auth::user();
		$users = User::orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('users', 'subject'));
	}

 	/*
	 * Get all projects.
	 */
	public function getProjects()
	{
		$subject = Auth::user();
		$projects = Project::orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('projects', 'subject'));
	}

	/*
	 * Get all organizations.
	 */
	public function getOrganizations()
	{
		$subject = Auth::user();
		$organizations = Organization::orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('organizations', 'subject'));
	}
}
