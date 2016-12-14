<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\Http\Requests;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
	/**
	 * Show the leaderboards.
	 */
    public function getIndex()
    {
    	$subject = Auth::user();
		$links = self::LINKS;
		$games = Game::all();
		dd($games);

    	return view('content.game.leaderboards', compact('subject', 'links'));
    }
}
