<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\User;
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

		$klaverjassen = $games->where("type", Game::KLAVERJASSEN);
		$klaverjassen = $klaverjassen->map(function ($game) {
			return [
				'winners' => array_keys((array) $game->getData('winners')),
				'losers' => array_keys((array) $game->getData('losers'))
			];
		});
		$klaverjassen = $this->sumScores($klaverjassen);

		$hartenjagen = $games->where("type", Game::HARTENJAGEN);
		$hartenjagen = $hartenjagen->map(function ($game) {
			return [
				'winners' => array_keys((array) $game->getData('winners')),
				'losers' => array_keys((array) $game->getData('losers'))
			];
		});
		$hartenjagen = $this->sumScores($hartenjagen);

    	return view('content.game.leaderboards', compact('subject', 'links', 'hartenjagen', 'klaverjassen'));
    }

    /**
     * Sum scores per user.
     * @param $array
     */
    private function sumScores($collection) {
    	$totals = ["winners" => [], "losers" => []];
    	foreach($collection as $item) {
    		$totals["winners"] = array_merge($totals["winners"], $item["winners"]);
    		$totals["losers"] = array_merge($totals["losers"], $item["losers"]);
    	};
    	$totals["winners"] = array_count_values($totals["winners"]);
    	$totals["losers"] = array_count_values($totals["losers"]);

    	return $totals;
    }
}
