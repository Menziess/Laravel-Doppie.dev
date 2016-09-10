<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use SoftDeletes;

	const LEVEL_CONST = 0.1;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'facebook_id',
		'data',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
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

	# Profile relation
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

	# Resource relation
	public function resource()
	{
		return $this->hasOne(Resource::class);
	}

	# Resources relation
	public function resources()
	{
		return $this->hasMany(Resource::class);
	}

	# Users relation
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	# Games relation
	public function games()
	{
		return $this->belongsToMany(Game::class);
	}

	# Owned games relation
	public function ownedGames()
	{
		return $this->belongsToMany(Game::class, 'owner_id', 'id');
	}

	/*
	 * Gets users full name.
	 */
	public function getName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	/*
	 * Gets user  xp.
	 */
	public function getXp()
	{
		return $this->xp;
	}

	/*
	 * Gets total amount of xp.
	 */
	public function getXpNext()
	{
		return pow(($this->getLevel() / self::LEVEL_CONST), 2);
	}

	/*
	 * Get user level.
	 */
	public function getLevel()
	{
		return 1 + round(self::LEVEL_CONST * sqrt($this->xp));
	}

	/*
	 * Increases the users xp by a certain amount.
	 */
	public function giveXp(int $amount)
	{
		$this->xp += $amount;
		$this->save();
	}

	/*
	 * Gets profile picture.
	 */
	public function getPicture()
	{
		return $this->profile->resource
			? 'storage/images/' . $this->profile->resource->original_name . $this->profile->resource->original_extension
			: 'img/placeholder.jpg';
	}

	/*
	 * Gets public profile url.
	 */
	public function getProfileUrl()
	{
		return '/user/profile/' . $this->getKey();
	}

	/**
	 * Activates a user.
	 *
	 * @return void
	 */
	public function activate()
	{
		$this->restore();
		$this->is_active = true;
		$this->save();
	}

	/**
	 * Deactivates a user.
	 *
	 * @return void
	 */
	public function deactivate()
	{
		$this->is_active = false;
		$this->save();
		$this->delete();
	}

	/**
	 * Makes this user admin.
	 *
	 * @return void
	 */
	public function makeAdmin(bool $true)
	{
		$this->is_admin = $true;
		$this->save();
	}

	/**
	 * Force delete user and all related private data.
	 *
	 * @return bool
	 */
	public function deleteAllPrivateData()
	{
		# Delete additional private data
		if ($this->profile->resource) {
			$this->profile->resource->removeFromStorage();
		}

		# Delete user
		$this->forceDelete();
	}

	/**
	 * Grab data attribute.
	 *
	 * @param 	string	$key
	 * @return 	mixed
	 */
	public function getData($key)
	{
		$data = is_null($this->data) ? new \stdClass() : json_decode(json_encode($this->data));
		return isset($data->{$key}) ? $data->{$key} : null;
	}

	/**
	 * Set data attribute.
	 *
	 * @param 	string	$key
	 * @param 	mixed	$value
	 * @return 	App\Content
	 */
	public function setData($key, $value)
	{
		$data = is_null($this->data) ? new \stdClass() : json_decode(json_encode($this->data));
		$data->{$key} = $value;
		$data = (object) array_merge((array) $this->data, (array) $data);
		$this->attributes['data'] = json_encode($data);

		return $this;
	}
}
