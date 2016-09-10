<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
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
	 */
	public function getIndex($id = null)
	{
		$subject = Auth::user();
		$links = self::LINKS;
		$games = Game::finished()->orderBy('id', 'desc')->take(10)->get();

		return view('content.game.scores', compact('links', 'subject', 'games'));
	}

	/**
	 * Show a played game.
	 *
	 * @param  int  $id
	 */
	public function show($id)
	{
		$subject = Auth::user();
		$links = self::LINKS;
		$game = Game::findOrFail($id);

		$winners = User::whereIn('id', array_keys((array) $game->getData('winners')))->get();
		$losers = User::whereIn('id', array_keys((array) $game->getData('losers')))->get();

    	return view('content.game.board', compact('game', 'subject', 'links'));
	}
}
