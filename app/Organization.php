<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'organizations';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
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
	protected $dates = ['deleted_at'];

	# Define relation
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	# Define relation
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	# Project relation
	public function projects()
	{
		return $this->hasMany(Project::class);
	}

	# Define relation
	public function resource()
	{
		return $this->belongsTo(Resource::class);
	}

	# Get first and last name
	public function getName()
	{
		return $this->name;
	}

	# Get amount of xp aquired
	public function getXp()
	{
		return $this->xp;
	}

	# Get owner name
	public function getOwnerName()
	{
		return $this->user ? $this->user->getName() : 'No owner';
	}

	/**
	 * Activates an organization.
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
	 * Deactivates an organization.
	 *
	 * @return void
	 */
	public function deactivate()
	{
		$this->is_active = false;
		$this->save();
		$this->delete();
	}

	# Get profile picture
	public function getPicture()
	{
		return $this->resource
			? 'storage/images/' . $this->resource->original_name . $this->resource->original_extension
			: 'img/organization.jpg';
	}

	# Get link to profile
	public function getProfileUrl()
	{
		$url = Auth::user()->is_admin ? '/admin/organization-profile/' . $this->getKey() : '/organization/profile/' . $this->getKey();
		return $url;
	}

	/**
	 * Force delete organization and all related private data.
	 *
	 * @return bool
	 */
	public function deleteAllPrivateData()
	{
		# delete additional private data
		if ($this->resource) {
			$this->resource->removeFromStorage();
		}
		$this->forceDelete();
	}
}
