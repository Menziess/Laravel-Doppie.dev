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
	const SUBJECTS = [
		['title' => 'All Users', 'href' => 'admin/users', 'text' => ''],
		['title' => 'All Projects', 'href' => 'admin/projects', 'text' => ''],
		['title' => 'All Organizations', 'href' => 'admin/organizations', 'text' => ''],
	];

	/*
	 * Get admin dashboard.
	 */
	public function getIndex(Request $request)
	{
		$input = $request->search;
		$search = '%' . $input . '%' ?: '%';
		$links = self::SUBJECTS;
		$subject = Auth::user();
		$users = User::withTrashed()
			->where('first_name', 'like', $search)
			->orWhere('last_name', 'like', $search)
			->orWhere('email', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		$projects = Project::withTrashed()->where('name', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		$organizations = Organization::withTrashed()->where('name', 'like', $search)
			->orderBy('id', 'desc')->paginate(7);
		return view('content.subject.list', compact('users', 'projects', 'organizations', 'subject', 'links', 'input'));
	}

	/**
	 * Get links for a particular model to related pages.
	 *
	 * @param  int 		$id
	 * @param  string 	$model
	 * @return array
	 */
	private static function getSubjectLinks($id, $model)
	{
		return [
			['title' => ucwords($model) . ' Profile', 'href' => '/admin/' . $model . '-profile/' . $id, 'text' => ''],
			['title' => ucwords($model) . ' Settings', 'href' => '/admin/' . $model . '-settings/' . $id, 'text' => ''],
			['title' => ucwords($model) . ' Subjects', 'href' => '/admin/' . $model . '-subjects/' . $id, 'text' => ''],
		];
	}

	/*
	|--------------------------------------------------------------------------
	| User routes
	|--------------------------------------------------------------------------
	|
	| For getting and modifying user information as a administrator.
	|
	*/

	/*
	 * Get all users.
	 */
	public function getUsers()
	{
		$links = self::SUBJECTS;
		$subject = Auth::user();
		$users = User::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('users', 'subject', 'links'));
	}

	/*
	 * Get user profile by id.
	 */
	public function getUserProfile($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'user');
		$subject = User::withTrashed()->findOrFail($id);
		return view('content.user.profile', compact('subject', 'links', 'in'));
	}

	/*
	 * Get user subjects by id.
	 */
	public function getUserSubjects($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'user');
		$subject = User::withTrashed()->findOrFail($id);
		return view('content.user.subjects', compact('subject', 'links', 'in'));
	}

	/*
	 * Get user settings by id.
	 */
	public function getUserSettings($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'user');
		$subject = User::withTrashed()->findOrFail($id);
		return view('content.user.settings', compact('subject', 'links', 'in'));
	}

	/*
	 * Toggle user is admin by id.
	 */
	public function putToggleadmin($id)
	{
		User::withTrashed()->findOrFail($id)->makeAdmin();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Activate user by id.
	 */
	public function putActivateUser($id)
	{
		User::withTrashed()->findOrFail($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Deactivate user by id.
	 */
	public function putDeactivateUser($id)
	{
		User::withTrashed()->findOrFail($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	|--------------------------------------------------------------------------
	| Project routes
	|--------------------------------------------------------------------------
	|
	| For getting and modifying project information as a administrator.
	|
	*/

	/*
	 * Get all projects.
	 */
	public function getProjects()
	{
		$links = self::SUBJECTS;
		$subject = Auth::user();
		$projects = Project::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('projects', 'subject', 'links'));
	}

	/*
	 * Get project profile by id.
	 */
	public function getProjectProfile($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'project');
		$subject = Project::withTrashed()->findOrFail($id);
		return view('content.project.profile', compact('subject', 'links', 'in'));
	}

	/*
	 * Get project subjects by id.
	 */
	public function getProjectSubjects($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'project');
		$subject = Project::withTrashed()->findOrFail($id);
		return view('content.project.subjects', compact('subject', 'links', 'in'));
	}

	/*
	 * Get project settings by id.
	 */
	public function getProjectSettings($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'project');
		$subject = Project::withTrashed()->findOrFail($id);
		return view('content.project.settings', compact('subject', 'links', 'in'));
	}

	/*
	 * Activate project by id.
	 */
	public function putActivateProject($id)
	{
		Project::withTrashed()->findOrFail($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Deactivate project by id.
	 */
	public function putDeactivateProject($id)
	{
		Project::withTrashed()->findOrFail($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	|--------------------------------------------------------------------------
	| Organization routes
	|--------------------------------------------------------------------------
	|
	| For getting and modifying organization information as a administrator.
	|
	*/

	/*
	 * Get all organizations by id.
	 */
	public function getOrganizations()
	{
		$links = self::SUBJECTS;
		$subject = Auth::user();
		$organizations = Organization::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.subject.list', compact('organizations', 'subject', 'links'));
	}

	/*
	 * Get organization profile by id.
 	 */
	public function getOrganizationProfile($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'organization');
		$subject = Organization::withTrashed()->findOrFail($id);
		return view('content.organization.profile', compact('subject', 'links', 'in'));
	}

	/*
	 * Get organization subjects by id.
	 */
	public function getOrganizationSubjects($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'organization');
		$subject = Organization::withTrashed()->findOrFail($id);
		return view('content.organization.subjects', compact('subject', 'links', 'in'));
	}

	/*
	 * Get organization settings by id.
	 */
	public function getOrganizationSettings($id)
	{
		$in = true;
		$links = self::getSubjectLinks($id, 'organization');
		$subject = Organization::withTrashed()->findOrFail($id);
		return view('content.organization.settings', compact('subject', 'links', 'in'));
	}

	/*
	 * Activate organization by id.
	 */
	public function putActivateOrganization($id)
	{
		Organization::withTrashed()->findOrFail($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Deactivate organization by id.
	 */
	public function putDeactivateOrganization($id)
	{
		Organization::withTrashed()->findOrFail($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}
}
