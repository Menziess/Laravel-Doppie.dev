<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	use SoftDeletes;

	const MODEL = 'organization';
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
	public function resource()
	{
		return $this->belongsTo(Resource::class);
	}

	# Define relation
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	# Project relation
	public function projects()
	{
		return $this->belongsToMany(Project::class);
	}

	# Get first and last name
	public function getName()
	{
		return $this->name;
	}

	# Get model
	public function getModel()
	{
		return self::MODEL;
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
	 * Force delete project and all related private data if it doesn't have
	 * related users or projects.
	 *
	 * @return string
	 */
	public function deleteAllPrivateData()
	{
		if ($this->users->count() > 1 || $this->projects->count() > 1) {
			return 'Cannot delete organization because it has other users or projects.';
		} else {
			# Delete additional private data
			if ($this->resource) {
				$this->resource->removeFromStorage();
			}
			# Delete Project
			$this->forceDelete();
		}
	}
}
