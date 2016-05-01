<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'profiles';

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		//
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
	 * Cast dates to Carbon instance.
	 *
	 * @var array
	 */
	protected $dates = [
		'date_of_birth',
	];

	/**
	 * Define relation.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Define relation.
	 */
	public function resource()
	{
		return $this->belongsTo(Resource::class);
	}
}
