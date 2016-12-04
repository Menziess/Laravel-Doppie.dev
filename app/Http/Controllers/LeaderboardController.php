<?php

namespace App\Http\Controllers;

use Auth;
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

    	return view('content.game.leaderboards', compact('subject', 'links'));
    }
}
