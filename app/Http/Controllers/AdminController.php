<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Auth;
use App\User;
use App\Project;
use App\Organization;
use App\Http\Requests;

class AdminController extends Controller
{
	const RESOURCES = [
		['title' => 'Users', 'href' => 'admin/users', 'text' => ''],
		['title' => 'Projects', 'href' => 'admin/projects', 'text' => ''],
		['title' => 'Organizations', 'href' => 'admin/organizations', 'text' => ''],
	];
	const USER = [
		['title' => 'Back', 'href' => 'admin/users', 'text' => ''],
	];
	const PROJECT = [
		['title' => 'Back', 'href' => 'admin/projects', 'text' => ''],
	];
	const ORGANIZATION = [
		['title' => 'Back', 'href' => 'admin/organizations', 'text' => ''],
	];

	public function getIndex(Request $request)
	{
		$links = self::RESOURCES;
		$subject = Auth::user();
		$users = User::withTrashed()->orderBy('id', 'desc')->paginate(7);
		$projects = Project::withTrashed()->orderBy('id', 'desc')->paginate(7);
		$organizations = Organization::withTrashed()->orderBy('id', 'desc')->paginate(7);
		return view('content.subject.subjects', compact('users', 'projects', 'organizations', 'subject', 'links'));
	}

	public function getUsers()
	{
		$links = self::RESOURCES;
		$subject = Auth::user();
		$users = User::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.subject.subjects', compact('users', 'subject', 'links'));
	}

	public function getProjects()
	{
		$links = self::RESOURCES;
		$subject = Auth::user();
		$projects = Project::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.subject.subjects', compact('projects', 'subject', 'links'));
	}

	public function getOrganizations()
	{
		$links = self::RESOURCES;
		$subject = Auth::user();
		$organizations = Organization::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.subject.subjects', compact('organizations', 'subject', 'links'));
	}

	public function getUser($id)
	{
		$in = true;
		$links = self::USER;
		$user = User::withTrashed()->find($id);
		$subject = $user;
		if (!$user) {
			abort(404);
		}
		return view('content.user.settings', compact('subject', 'user', 'links', 'in'));
	}

	public function getProject($id)
	{
		$in = true;
		$links = self::PROJECT;
		$project = Project::withTrashed()->find($id);
		$subject = $project;
		if (!$project) {
			abort(404);
		}
		return view('content.project.settings', compact('subject', 'project', 'links', 'in'));
	}

	public function getOrganization($id)
	{
		$in = true;
		$links = self::ORGANIZATION;
		$organization = Organization::withTrashed()->find($id);
		$subject = $organization;
		if (!$organization) {
			abort(404);
		}
		return view('content.organization.settings', compact('subject', 'organization', 'links', 'in'));
	}

	/*
	 * Toggles user is admin.
	 */
	public function putToggleadmin($id)
	{
		User::withTrashed()->find($id)->makeAdmin();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Restores a user and sets is_active on true.
	 */
	public function putActivateUser($id)
	{
		User::withTrashed()->find($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Soft deletes user and sets is_active on false.
	 */
	public function putDeactivateUser($id)
	{
		User::withTrashed()->find($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Restores a project and sets is_active on true.
	 */
	public function putActivateProject($id)
	{
		Project::withTrashed()->find($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Soft deletes project and sets is_active on false.
	 */
	public function putDeactivateProject($id)
	{
		Project::withTrashed()->find($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Restores a organization and sets is_active on true.
	 */
	public function putActivateOrganization($id)
	{
		Organization::withTrashed()->find($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Soft deletes organization and sets is_active on false.
	 */
	public function putDeactivateOrganization($id)
	{
		Organization::withTrashed()->find($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}
}
