<?php

namespace App;

use Auth;
use App\User;
use App\Helpers\JsonAble;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use JsonAble;
    use SoftDeletes;

    const KLAVERJASSEN = "Klaverjassen";
    const HARTENJAGEN = "Hartenjagen";

    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'games';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'data',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		//
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'finished_at',
		'started_at',
		'deleted_at',
	];

	/**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /*
     * Relation with users.
     */
	public function users()
	{
		return $this->belongsToMany(User::class)->withTrashed();
	}

	/*
	 * Relation with owner.
	 */
	public function user()
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

	/*
	 * Gets url.
	 */
	public function getUrl()
	{
		return '/admin/game/' . $this->getKey();
	}

	/*
	 * Gets profile picture.
	 */
	public function getPicture()
	{
		if ($this->type == self::HARTENJAGEN) {
			return 'img/games/heart.png';
		} elseif ($this->type == self::KLAVERJASSEN) {
			return 'img/games/clover.png';
		} else {
			return 'img/placeholder.jpg';
		}
	}

	/*
	 * Get amount of points that can be won each round.
	 */
	public function getPointsPerRound()
	{
		if ($this->type == self::HARTENJAGEN) {
	        return count($this->users) > 4 ? (count($this->users) - 4) * 2 + 15 : 15;
		} elseif ($this->type == self::KLAVERJASSEN) {
			return 162;
		}
	}

	/**
	 * Get active game.
	 *
	 * @return query
	 */
	public function scopeActive($query)
	{
		return $query->whereNull('finished_at');
	}

	/**
	 * Get finished game.
	 *
	 * @return query
	 */
	public function scopeFinished($query)
	{
		return $query->whereNotNull('finished_at');
	}

	/*
	 * Adds a player to the game.
	 */
	public function addPlayersById(array $users)
	{
		$this->users()->detach();
		if ($users) {
			$this->users()->sync($users);
		}
	}

	/*
	 * Removes a player from the game.
	 */
	public function removePlayer(User $user)
	{
		$this->users()->detach($user);
	}

	/*
	 * Persists the score of a round of Hartenjagen.
	 */
	public function saveHartenjagenScore($request, $users)
	{
		$scores = $this->data['scores'];
		$round = count($scores);
		$totals = $this->getTotalHartenjagenScores();

		if ($this->getData('punten_halen')) {
			foreach ($users as $user => $points) {
				if ($totals[$user] - $points < 1) {
		        	$scores[$round][$user] = - $totals[$user];
		            $scores[$round + 1][$user] = 0;
				} else {
					$scores[$round][$user] = $points ? (int) - ltrim($points, '0') : 0;
		            $scores[$round + 1][$user] = 0;
				}
			}
		} else {
			foreach ($users as $user => $points) {
				if ($totals[$user] + $points > 49) {
		            $scores[$round][$user] = (50 - $totals[$user]);
		            $scores[$round + 1][$user] = 0;
				} else {
					$scores[$round][$user] = $points ? (int) ltrim($points, '0') : 0;
		            $scores[$round + 1][$user] = 0;
				}
			}
		}

        $this->setData('scores', $scores);
        $this->save();

        $totals = $this->getTotalHartenjagenScores();

        if (!$this->getData('punten_halen') && in_array(50, $totals)) {
			 $this->setData('punten_halen', true);
             $request->session()->flash('message', 'Punten halen.');
        }

        $this->save();

        if ($this->getData('punten_halen') && in_array(0,  $totals)) {
        	return $this->finish();
        }

        return redirect('/game#bottom');
	}

	/*
	 * Persists the score of a round of Klaverjassen.
	 */
	public function saveKlaverjassenScore($request, $inputs)
	{
		$scores = $this->data['scores'];
		$round = count($scores);
		$totals = $this->getTotalKlaverjassenScores();

		foreach ($inputs as $input => $points) {
			$scores[$round][$input] = $points ? (int) ltrim($points, '0') : 0;
            $scores[$round + 1][$input] = 0;
		}

        $this->setData('scores', $scores);
        $this->save();

        $totals = $this->getTotalKlaverjassenScores();

		if ($round >= 16) {
			return $this->finish();
		}

        return redirect('/game#bottom');
    }

	/*
	 * Starts the game.
	 */
	public function start()
	{
		$this->started_at = Carbon::now();
		if ($this->type == self::HARTENJAGEN) {
			foreach ($this->users as $key => $user) {
	            $round[1][$user->id] = 0;
	        }
		} elseif ($this->type == self::KLAVERJASSEN) {
			$round[1]["Wij"] = 0;
			$round[1]["Wij-roem"] = 0;
			$round[1]["Zij"] = 0;
			$round[1]["Zij-roem"] = 0;
		}
        $this->setData('scores', $round);
        $this->user()->associate(Auth::user());
		$this->save();
	}

	/*
	 * Finish the game.
	 */
	public function finish()
	{
		$this->finished_at = Carbon::now();

		if ($this->type == self::HARTENJAGEN) {
			$total = $this->getTotalHartenjagenScores();
			$winners = $this->setWinners($total);
			$losers = $this->setLosers($total);
			$this->setData('winners', $winners);
			$this->setData('losers', $losers);
			$this->setHartenjagenXp($winners);
			$this->setHartenjagenXp($losers);
		} elseif ($this->type == self::KLAVERJASSEN) {
			$total = $this->getTotalKlaverjassenScores();
			$teams = $this->getWinningAndLosingTeams($total);
			$winners = $teams['winners'];
			$losers = $teams['losers'];
			$this->setData('winners', $winners);
			$this->setData('losers', $losers);
			$this->setKlaverjassenXp($winners, TRUE);
			$this->setKlaverjassenXp($losers, FALSE);
		}

		$this->save();

		return redirect('/scores/' . $this->id);
	}

	/*
	 * Get games total scores for each user.
	 */
	public function getTotalHartenjagenScores()
	{
		$totals = [];

		foreach($this->users as $user) {

			$total = 0;
			foreach($this->data['scores'] as $round => $value) {
				$total += $this->data['scores'][$round][$user->id];
			}
			$totals[$user->id] = $total;
		}

		return $totals;
	}

	/*
	 * Get games total scores for each team.
	 */
	public function getTotalKlaverjassenScores()
	{
		$totals = [];

		foreach(array_keys($this->getTeams()) as $team) {

			for ($i=0; $i < 2; $i++) {
				$total = 0;
				foreach($this->data['scores'] as $round => $value) {
					$total += $this->data['scores'][$round][$team];
				}
				$totals[$team] = $total;
				$team = $team . '-roem';
			}

		}

		return $totals;
	}

	/**
	 * Gets Wij team for klaverjassen.
	 * @return array
	 */
	public function getTeams() {
		if (!$this->user) abort("Game hasn't got a user");
		$teams = $this->users[0]->id == $this->user->id || $this->users[2]->id == $this->user->id ?
			[
				'Wij' => [$this->users[0], $this->users[2]],
			 	'Zij' => [$this->users[1], $this->users[3]]
			] :
			[
				'Wij' => [$this->users[1], $this->users[3]],
				'Zij' => [$this->users[0], $this->users[2]]
			];

		return $teams;
	}

	/**
	 * @param  Return players with score of 0.
	 * @return array
	 */
	private function setWinners(array $totals)
	{
		return array_filter($totals, function ($w) {
    		return $w == 0;
    	});
	}

	/**
	 * @param  Return players with score greater than 0.
	 * @return array
	 */
	private function setLosers(array $totals)
	{
		return array_filter($totals, function ($l) {
			return $l > 0;
		});
	}

	/**
	 * Determine winning and losing teams.
	 * @param  array $total
	 * @return array
	 */
	private function getWinningAndLosingTeams($total) {
		$teams = $this->getTeams();

		$wij_score = $total['Wij'] + $total['Wij-roem'];
		$zij_score = $total['Zij'] + $total['Zij-roem'];

		$wij = [
			$teams['Wij'][0]->id => $wij_score,
			$teams['Wij'][1]->id => $wij_score,
		];

		$zij = [
			$teams['Zij'][0]->id => $zij_score,
			$teams['Zij'][1]->id => $zij_score,
		];

		$teams = ['winners' => [], 'losers' => []];

		if ($wij_score > $zij_score) {
			$teams['winners'] = $wij;
			$teams['losers'] = $zij;
		} elseif ($wij_score < $zij_score) {
			$teams['winners'] = $zij;
			$teams['losers'] = $wij;
		} else {
			$teams['winners'] = array_merge($wij, $zij);
		}

		return $teams;
	}

	/**
	 * Gives experience points to all players after Hartenjagen.
	 *
	 * @param array $winners
	 * @param array $losers
	 */
	private function setHartenjagenXp(array $players)
	{
		foreach($players as $player => $score) {
			$user = User::find($player);
			$user->setWinner(0 == $score);
			$user->giveXp(50 - ($score == 0 ? - 10 : $score));
			$user->save();
		}
	}

	/**
	 * Gives experience points to all players after Klaverjassen.
	 *
	 * @param array $winners
	 * @param array $losers
	 */
	private function setKlaverjassenXp(array $players, bool $won)
	{
		foreach($players as $player => $score) {
			$user = User::find($player);
			$user->setWinner($won);
			$user->giveXp($won ? 50 + 20 : 25);
			$user->save();
		}
	}
}
