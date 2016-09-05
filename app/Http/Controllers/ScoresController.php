<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\Http\Requests;
use Illuminate\Http\Request;

class ScoresController extends Controller
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
		$links = self::LINKS;
		$games = Game::orderBy('id', 'desc')->take(10);

		return view('content.game.scores', compact('links', 'subject', 'games'));
	}
}
