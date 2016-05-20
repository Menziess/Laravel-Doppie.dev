<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use SoftDeletes;

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
		'first_name', 'last_name', 'email', 'facebook_id',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'deleted_at',
	];

	# Profile relation
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

	# Profile relation
	public function organization()
	{
		return $this->hasOne(Organization::class);
	}

	# Resource relation
	public function resources()
	{
		return $this->hasMany(Resource::class);
	}

	# User relation
	public function users()
	{
		return $this->belongsToMany(User::class, 'user_user', 'user_id', 'related_id')
			->withPivot('type');;
	}

	# Project relation
	public function projects()
	{
		return $this->belongsToMany(Project::class);
	}

    # The organizations that belong to the user.
    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

	/*
	 * Gets users full name.
	 */
	public function getName()
	{
		return $this->first_name . ' ' . $this->last_name;
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
		# Delete all projects if not related to other subjects
		if ($this->projects) {
			foreach ($this->projects as $project) {
				$project->forceDelete();
			}
		}
		# Delete user
		$this->forceDelete();
	}
}
