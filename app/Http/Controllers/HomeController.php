<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
		$links = [
			['title' => 'New Project', 'href' => 'project', 'text' => '']
		];
		return view('home', compact('links', 'subject'));
	}
}
