<?php

namespace App;

use Image;
use Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
	use SoftDeletes;

	const MODEL = 'resource';

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'resources';

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

	/*
	 * Relation with user.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/*
	 * Relation with profile.
	 */
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

	/*
	 * Relation with organization.
	 */
	public function organization()
	{
		return $this->hasOne(Organization::class);
	}

	/**
	 * Create new image from file.
	 *
	 * @param  File    $file
	 * @param  integer $width
	 * @param  integer $height
	 * @return string  $filepath
	 */
	public function uploadImageFile($file, $width = 1000, $height = 1000)
	{
		$image = Image::make($file)->orientate()->fit($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

		$this->original_name = self::generateName();
		$this->original_mime_type = $file->getClientMimeType();
		$this->original_extension = '.' . $file->getClientOriginalExtension();
		return self::storeImage($image);
	}

	/**
	 * Create new image from path.
	 *
	 * @param  string  $path
	 * @param  integer $width
	 * @param  integer $height
	 * @return string  $filepath
	 */
	public function uploadImagePath($path, $width = 1000, $height = 1000)
	{
		$image = Image::make($path)->orientate()->resize($width, $height);
		$this->original_name = self::generateName();
		$this->original_mime_type = $image->mime();
		$this->original_extension = pathinfo($path, PATHINFO_EXTENSION)
			?: $this->getExtension($this->original_mime_type);
		return self::storeImage($image);
	}

	/**
	 * Store image in storage.
	 *
	 * @param  Image 	$image
	 * @return string 	$filepath
	 */
	private function storeImage($image)
	{
		$filepath = 'public/images/' . $this->original_name . $this->original_extension;
		$image->interlace();
		$image->save(storage_path('app/' . $filepath));

		return $filepath;
	}

	/**
	 * Remove from storage.
	 *
	 * @param  string $file name + extension
	 * @return void
	 */
	public function removeFromStorage()
	{
		$filepath = 'public/images/' . $this->original_name . $this->original_extension;
		Storage::delete($filepath);
		$this->delete();
	}

	/**
	 * Generate a new name, that can be used as file/resource name.
	 *
	 * @return string
	 */
	public static function generateName()
	{
		return md5(uniqid(rand(), true));
	}

	/**
	 * Use mime type to get a guessed extension.
	 *
	 * @param  string $mime_type
	 * @return string $extension
	 */
	private static function getExtension ($mime_type) {
		$extensions = [
			'image/jpeg' => '.jpeg',
			"image/png" => '.png',
			"image/gif" => '.gif',
			'text/xml' => '.xml',
			"image/x-ms-bmp" => '.bmp',
		];
		return $extensions[$mime_type];
	}
}
