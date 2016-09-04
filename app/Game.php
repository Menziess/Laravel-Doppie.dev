<?php

namespace App;

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

	/**
	 * Get active game.
	 *
	 * @return query
	 */
	public function scopeActive($query) {
		return $query->whereNull('finished_at');
	}

	/*
	 * Adds a player to the game.
	 */
	public function addPlayer(User $user) {
		if (!$this->users->contains($user->id)) {
			 $this->users()->attach($user);
		}
	}

	/*
	 * Removes a player from the game.
	 */
	public function removePlayer(User $user) {
		$this->users()->detach($user);
	}

	/*
	 * Starts the game.
	 */
	public function start() {
		$this->started_at = Carbon::now();
        $round = [];
        foreach ($this->users as $key => $user) {
            $round[1][$user->first_name] = 0;
        }
        $this->score = $round;
		$this->save();
	}
}
