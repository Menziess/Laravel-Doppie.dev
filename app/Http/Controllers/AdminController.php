<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Organization;
use App\Http\Requests;

class AdminController extends Controller
{
	const LINKS = [
			['title' => 'Users', 'href' => 'admin/users', 'text' => ''],
			['title' => 'Organizations', 'href' => 'admin/organizations', 'text' => ''],
		];

	public function getUsers()
	{
		$in = true;
		$links = self::LINKS;
		$subject = Auth::user();
		$users = User::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.admin.users', compact('users', 'subject', 'links', 'in'));
	}

	public function getOrganizations()
	{
		$in = true;
		$links = self::LINKS;
		$subject = Auth::user();
		$organizations = Organization::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.admin.organizations', compact('organizations', 'subject', 'links', 'in'));
	}

	public function getUser($id)
	{
		$links = self::LINKS;
		$user = User::withTrashed()->find($id);
		if (!$user) {
			return redirect('admin/users');
		}
		return view('content.user.settings', compact('user', 'links'));
	}

	public function getOrganization($id)
	{
		$links = self::LINKS;
		$organization = Organization::withTrashed()->find($id);
		if (!$organization) {
			return redirect('admin/organizations');
		}
		return view('content.organization.settings', compact('organization', 'links'));
	}

	/*
	 * Soft deletes user and sets is_active on false.
	 */
	public function getToggleadmin($id)
	{
		$user = User::withTrashed()->find($id);
		$user->makeAdmin();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Restores a user and sets is_active on true.
	 */
	public function getActivate($id)
	{
		User::withTrashed()->find($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Soft deletes user and sets is_active on false.
	 */
	public function getDeactivate($id)
	{
		User::withTrashed()->find($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}
}
