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
	 * Get amount of points that can be won each round.
	 */
	public function getPointsPerRound()
	{
        return count($this->users) > 4 ? (count($this->users) - 4) * 2 + 15 : 15;
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
	 * Persists the score of a round.
	 */
	public function saveScore($request, $users)
	{
		$scores = $this->data['scores'];
		$round = count($scores);
		$totals = $this->getTotalScores();

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

        $totals = $this->getTotalScores();

        if (!$this->getData('punten_halen') && self::hasAmountPoints($totals, 50)) {
			 $this->setData('punten_halen', true);
             $request->session()->flash('message', 'Punten halen.');
        }

        $this->save();

        if ($this->getData('punten_halen') && self::hasAmountPoints($totals, 0)) {
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
        foreach ($this->users as $key => $user) {
            $round[1][$user->id] = 0;
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
		$total = $this->getTotalScores();
		$winners = $this->setWinners($total);
		$losers = $this->setLosers($total);
		$this->setData('winners', $winners);
		$this->setData('losers', $losers);
		$this->setXp($winners);
		$this->setXp($losers);
		$this->save();

		return redirect('/scores/' . $this->id);
	}

	/*
	 * Get games total scores for each user.
	 */
	public function getTotalScores()
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

	/**
	 * @param  Return players with score of 0.
	 * @return array
	 */
	public function setWinners(array $totals)
	{
		return array_filter($totals, function ($w) {
    		return $w == 0;
    	});
	}

	/**
	 * @param  Return players with score greater than 0.
	 * @return array
	 */
	public function setLosers(array $totals)
	{
		return array_filter($totals, function ($l) {
			return $l > 0;
		});
	}

	/**
	 * Gives experience points to all players.
	 *
	 * @param array $winners
	 * @param array $losers
	 */
	private function setXp(array $players)
	{
		foreach($players as $player => $score) {
			$user = User::find($player);
			$user->setWinner(0 == $score);
			$user->giveXp(50 - ($score == 0 ? - 10 : $score));
			$user->save();
		}
	}

	/*
	 * Check if a user has 50 points.
	 */
	private static function hasAmountPoints(array $totals, int $amount)
	{
		foreach ($totals as $total => $value) {
			if ($value == $amount) {
				return true;
			}
		}
	}
}
