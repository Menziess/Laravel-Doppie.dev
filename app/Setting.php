<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';

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
	 * Define relation.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
