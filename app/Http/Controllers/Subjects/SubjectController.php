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
	/*
	 * Get a overview of all subjects.
	 */
	public function getIndex(Request $request)
	{
		$links = self::LINKS;
		$input = $request->search;
		$search = '%' . $input . '%' ?: '%';
		$subject = Auth::user();
		$users = User::where('first_name', 'like', $search)
			->orWhere('last_name', 'like', $search)
			->orWhere('email', 'like', $search)
			->orderBy('id', 'desc')->paginate();

		return view('content.all.list', compact('links', 'users', 'subject', 'input'));
	}

	/*
	 * Get all users.
	 */
	public function getUsers()
	{
		$subject = Auth::user();
		$users = User::orderBy('id', 'desc')->paginate();
		return view('content.all.list', compact('users', 'subject'));
	}
}
