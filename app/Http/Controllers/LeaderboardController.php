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
		$klaverjassen = $this->winLossRatio($klaverjassen);

		$hartenjagen = $games->where("type", Game::HARTENJAGEN);
		$hartenjagen = $hartenjagen->map(function ($game) {
			return [
				'winners' => array_keys((array) $game->getData('winners')),
				'losers' => array_keys((array) $game->getData('losers'))
			];
		});
		$hartenjagen = $this->winLossRatio($hartenjagen);
        // dd($hartenjagen);

    	return view('content.game.leaderboards', compact('subject', 'links', 'hartenjagen', 'klaverjassen'));
    }

    /**
     * Sum scores per user.
     * @param $array
     */
    private function winLossRatio($collection) {
    	$totals = ["winners" => [], "losers" => []];
    	foreach($collection as $item) {
    		$totals["winners"] = array_merge($totals["winners"], $item["winners"]);
    		$totals["losers"] = array_merge($totals["losers"], $item["losers"]);
    	};
    	$totals["winners"] = array_count_values($totals["winners"]);
    	$totals["losers"] = array_count_values($totals["losers"]);

    	$sorted = $this->array_subtract($totals["winners"], $totals["losers"]);
    	arsort($sorted);

    	foreach($sorted as $playerId => $ratio) {
    		$sorted[$playerId] = [
    			User::findOrFail($playerId),
    			$ratio,
    			array_key_exists($playerId, $totals["winners"]) ? $totals["winners"][$playerId] : 0,
    			array_key_exists($playerId, $totals["losers"]) ? $totals["losers"][$playerId] : 0,
    		];
    	}

    	return $sorted;
    }

    /**
     * Subtract array values.
     * @param  array $a1
     * @param  array $a2
     * @return array
     */
    private function array_subtract($a1, $a2) {
		$aRes = $a1;
		foreach (array_slice(func_get_args(), 1) as $aRay) {
			foreach (array_intersect_key($aRay, $aRes) as $key => $val) $aRes[$key] -= $val;
			foreach (array_diff_key($aRay, $aRes) as $key => $val) $aRes[$key] = -$val;
		}
		return $aRes;
	}
}
