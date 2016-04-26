<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use SoftDeletes;

	const USER_IS_BLOCKED_BY_ADMIN = 'Sorry, this user is deactivated.';

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
		'first_name', 'last_name', 'email', 'password', 'facebook_id',
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

	/**
	 * Define relation.
	 */
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

	/**
	 * Define relation.
	 */
	public function setting()
	{
		return $this->hasOne(Setting::class);
	}

	/**
	 * Define relation.
	 */
	public function resource()
	{
		return $this->hasMany(Resource::class);
	}
}
