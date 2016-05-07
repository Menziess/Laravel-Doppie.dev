<?php

namespace App;

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

	# Gets the name of the owner
	public function getOwnerName()
	{
		return $this->user ? $this->user->getName() : 'No owner';
	}

	# Gets the name of the organization
	public function getOrganizationName()
	{
		return $this->organization ? $this->organization->getName() : 'No organization';
	}

	# Get profile picture
	public function getPicture()
	{
		return $this->resource
			? 'storage/images/' . $this->resource->original_name . $this->resource->original_extension
			: 'img/project.jpg';
	}
}
