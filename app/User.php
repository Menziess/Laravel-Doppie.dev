<?php

namespace App;

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
	protected $dates = ['deleted_at'];

	# Profile relation
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

	# Setting relation
	public function setting()
	{
		return $this->hasOne(Setting::class);
	}

	# Profile relation
	public function organization()
	{
		return $this->hasOne(Organization::class);
	}

    # The organizations that belong to the user.
    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

	# Resource relation
	public function resource()
	{
		return $this->hasMany(Resource::class);
	}

	# Get first and last name
	public function getName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	# Get profile picture
	public function getPicture()
	{
		return $this->profile->resource
			? 'storage/images/' . $this->profile->resource->original_name . $this->profile->resource->original_extension
			: 'img/placeholder.jpg';
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
		# delete additional private data
		if ($this->profile->resource) {
			$this->profile->resource->removeFromStorage();
		}
		$this->forceDelete();
	}
}
