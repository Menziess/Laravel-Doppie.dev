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
	const LINKS = [
		['title' => 'All Users', 'href' => 'admin/users', 'text' => ''],
	];

	/*
	 * Get admin dashboard.
	 */
	public function getIndex(Request $request)
	{
		$input = $request->search;
		$search = '%' . $input . '%' ?: '%';
		$links = self::LINKS;
		$subject = Auth::user();
		$users = User::withTrashed()
			->where('first_name', 'like', $search)
			->orWhere('last_name', 'like', $search)
			->orWhere('email', 'like', $search)
			->orderBy('id', 'desc')->paginate();

		return view('content.all.list', compact('users', 'subject', 'links', 'input'));
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
		$links = self::LINKS;
		$subject = Auth::user();
		$users = User::withTrashed()->orderBy('id', 'desc')->paginate(15);
		return view('content.all.list', compact('users', 'subject', 'links'));
	}

	/*
	 * Get user settings by id.
	 */
	public function getUser($id)
	{
		$links = self::LINKS;
		$subject = User::withTrashed()->findOrFail($id);
		return view('content.user.settings', compact('subject', 'links'));
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
}
