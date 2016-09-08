<?php

namespace App;

use Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
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

    # Users relation
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	# Owner relation
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	# Get points per round
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

	/*
	 * Adds a player to the game.
	 */
	public function addPlayer(User $user)
	{
		if (!$this->users->contains($user->id)) {
			 $this->users()->attach($user);
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

		if ($this->type == 'punten halen') {
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

        $this->data = ['scores' => $scores];
        $this->save();

        $totals = $this->getTotalScores();

        if ($this->type != 'punten halen' && self::hasAmountPoints($totals, 50)) {
			$this->type  = 'punten halen';
            $request->session()->flash('message', 'Punten halen.');
        }

        $this->save();

        if ($this->type == 'punten halen' && self::hasAmountPoints($totals, 0)) {
        	$winners = $this->getWinners($totals);
        	return $this->finish($winners);
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
        $this->data = ['scores' => $round];
        $this->user()->associate(Auth::user());
		$this->save();
	}

	/*
	 * Finish the game.
	 */
	public function finish()
	{
		$this->finished_at = Carbon::now();
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

			if (!isset($this->data['scores'])) {
				return null;
			}

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
	public function getWinners(array $totals)
	{
		return array_filter($totals, function ($w) {
    		return $w == 0;
    	});
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
