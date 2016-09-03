<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use SoftDeletes;

	const MODEL = 'user';

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
		'facebook_id',
		'date_of_birth',
		'gender',
		'latitude',
		'longitude',
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
		'date_of_birth',
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

	/*
	 * Gets users full name.
	 */
	public function getName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	/*
	 * Get model.
	 */
	public function getModel()
	{
		return self::MODEL;
	}

	/*
	 * Gets total amount of xp.
	 */
	public function getXp()
	{
		return $this->xp;
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
		$url = Auth::user()->is_admin ? '/admin/user-profile/' . $this->getKey() : '/user/profile/' . $this->getKey();
		return $url;
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
	public function makeAdmin()
	{
		$this->is_admin = !$this->is_admin;
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
}
