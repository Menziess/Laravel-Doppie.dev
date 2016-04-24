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
		'first_name', 'last_name', 'email', 'password',
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
	public function file()
	{
		return $this->hasMany(File::class);
	}

	/**
	 * Creates new or retrieves user with facebook_token.
	 *
	 * @param  string $facebook_token
	 * @return App\User $user
	 */
	public static function facebookL()
	{

		$user = User::withTrashed()->where('facebook_id', $id)->first();

		if (!$user) {
			$user = User::firstOrNew(['facebook_id' => $id]);
		}
	}
}
