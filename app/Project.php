<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'header',
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

	# Define relation
	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	# Define relation
	public function organizations()
	{
		return $this->belongsToMany(Organization::class);
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

	# Gets the name of the organization
	public function getOrganizationName()
	{
		return $this->organization ? $this->organization->getName() : 'No organization';
	}

	# Get link to profile
	public function getProfileUrl()
	{
		$url = Auth::user()->is_admin ? '/admin/project-profile/' . $this->getKey() : '/project/profile/' . $this->getKey();
		return $url;
	}

	/**
	 * Activates a project.
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
	 * Deactivates a project.
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
			: 'img/project.jpg';
	}

	/**
	 * Force delete project and all related private data if it doesn't have
	 * related users or organizations.
	 *
	 * @return string
	 */
	public function deleteAllPrivateData()
	{
		if ($this->users->count() > 0 || $this->organizations->count() > 0) {
			return 'Cannot delete project because it has other users or organizations.';
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
