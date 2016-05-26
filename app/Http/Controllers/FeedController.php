<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\Http\Requests;
use Illuminate\Http\Request;

class FeedController extends Controller
{
	const LINKS = [
		['title' => 'New Project', 'href' => 'project', 'text' => ''],
		['title' => 'New Organization', 'href' => 'organization', 'text' => ''],
	];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex()
	{
		$subject = Auth::user();
		$links = self::LINKS;
		return view('feed', compact('links', 'subject'));
	}
}
