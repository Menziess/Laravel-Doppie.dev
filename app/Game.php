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
		'score',
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
        'score' => 'array',
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
		$nr = count($this->score);
		$round = $this->score;
		$totals = $this->getTotalScores();
		foreach ($users as $user => $points) {
			if ($this->type == 'punten halen') {
	            $round[$nr][$user] = - ltrim($points, '0');
			} else if ($totals[$user] + $points > 50) {
	            $round[$nr][$user] = 50 - $totals[$user];
            } else {
	            $round[$nr][$user] = $points ? ltrim($points, '0') : 0;
            }
            $round[$nr + 1][$user] = 0;
        }
        $this->score = $round;
        $this->save();

        if ($this->type != 'punten halen' && self::hasFifty($totals)) { // todo totals has 50 value
			$this->type  = 'punten halen';
            $request->session()->flash('message', 'Punten halen.');
        }

        $this->save();

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
        $this->score = $round;
        $this->user()->associate(Auth::user());
		$this->save();
	}

	/*
	 * Get games total scores for each user.
	 */
	public function getTotalScores()
	{
		$totals = [];

		foreach($this->users as $user) {

			$total = 0;

			foreach($this->score as $round => $value) {
				$total += $this->score[$round][$user->id];
			}

			$totals[$user->id] = $total;
		}

		return $totals;
	}

	/*
	 * Check if a user has 50 points.
	 */
	private static function hasFifty(array $totals)
	{
		foreach ($totals as $total => $value) {
			if ($value == 50) {
				return true;
			}
		}
	}

	// /**
	//  * Data attribute getter.
	//  *
	//  * @return array
	//  */
	// public function getDataAttribute()
	// {
	// 	if (!isset($this->attributes['data'])) {
	// 		return null;
	// 	}

	// 	return json_decode($this->attributes['data']);
	// }

	// /**
	//  * Data attribute setter.
	//  *
	//  * @param  	array|object
	//  * @return	void
	//  */
	// public function setDataAttribute($data)
	// {
	// 	$data = (object) array_merge((array) $this->data, (array) $data);
	// 	$this->attributes['data'] = json_encode($data);
	// }

	// /**
	//  * Grab data attribute.
	//  *
	//  * @param 	string	$key
	//  * @return 	mixed
	//  */
	// public function getData($key)
	// {
	// 	$data = $this->data;
	// 	return isset($data->{$key}) ? $data->{$key} : null;
	// }

	// /**
	//  * Get data relation.
	//  *
	//  * @param 	string 	$key
	//  * @param 	mixed 	$class
	//  * @return 	mixed
	//  */
	// public function getDataRelation($key, $class)
	// {
	// 	$id = $this->getData($key);
	// 	$relation = new $class();

	// 	return $relation->find($id);
	// }

	// /**
	//  * Set data attribute.
	//  *
	//  * @param 	string	$key
	//  * @param 	mixed	$value
	//  * @return 	App\Content
	//  */
	// public function setData($key, $value)
	// {
	// 	$data = is_null($this->data) ? new \stdClass() : $this->data;
	// 	$data->{$key} = $value;
	// 	$this->data = $data;

	// 	return $this;
	// }
}
