<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Project;
use App\Organization;
use App\Http\Requests;

class SubjectController extends Controller
{
    const RESOURCES = [
		['title' => 'Users', 'href' => 'subject/users', 'text' => ''],
		['title' => 'Projects', 'href' => 'subject/projects', 'text' => ''],
		['title' => 'Organizations', 'href' => 'subject/organizations', 'text' => ''],
	];
	const USER = [
		['title' => 'Link', 'href' => '#', 'text' => ''],
	];
	const PROJECT = [
		['title' => 'Link', 'href' => '#', 'text' => ''],
	];
	const ORGANIZATION = [
		['title' => 'Link', 'href' => '#', 'text' => ''],
	];

	public function getIndex(Request $request)
	{
		$search = '%' . $request->search . '%' ?: '%';
		$links = self::RESOURCES;
		$subject = Auth::user();
		$users = User::where('first_name', 'like', $search)
			->orWhere('last_name', 'like', $search)
			->orWhere('email', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		$projects = Project::where('name', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		$organizations = Organization::where('name', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		return view('content.subject.list', compact('users', 'projects', 'organizations', 'subject', 'links'));
	}

	public function getUsers()
	{
		$links = self::RESOURCES;
		$subject = Auth::user();
		$users = User::orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('users', 'subject', 'links'));
	}

	public function getProjects()
	{
		$links = self::RESOURCES;
		$subject = Auth::user();
		$projects = Project::orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('projects', 'subject', 'links'));
	}

	public function getOrganizations()
	{
		$links = self::RESOURCES;
		$subject = Auth::user();
		$organizations = Organization::orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('organizations', 'subject', 'links'));
	}

	public function getUserProfile($id)
	{
		$in = true;
		$links = self::USER;
		$user = User::find($id);
		$subject = $user;
		if (!$user) {
			abort(404);
		}
		return view('content.user.profile', compact('subject', 'user', 'links', 'in'));
	}

	public function getProjectProfile($id)
	{
		$in = true;
		$links = self::PROJECT;
		$project = Project::find($id);
		$subject = $project;
		if (!$project) {
			abort(404);
		}
		return view('content.project.profile', compact('subject', 'project', 'links', 'in'));
	}

	public function getOrganizationProfile($id)
	{
		$in = true;
		$links = self::ORGANIZATION;
		$organization = Organization::find($id);
		$subject = $organization;
		if (!$organization) {
			abort(404);
		}
		return view('content.organization.profile', compact('subject', 'organization', 'links', 'in'));
	}
}
