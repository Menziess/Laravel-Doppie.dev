<?php

namespace App;

use Image;
use Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
	use SoftDeletes;

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
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

	/**
	 * Create new image.
	 *
	 * @param  string  $path
	 * @param  integer $width
	 * @param  integer $height
	 * @return string  $folderPath
	 */
	public function createNewImage($path, $width = 1000, $height = 1000)
	{
		$image = Image::make($path)->resize($width, $height);

		$this->original_name = self::generateName();
		$this->original_mime_type = $image->mime();
		$this->original_extension = pathinfo($path, PATHINFO_EXTENSION)
			?: $this->getExtension($this->original_mime_type);

		$filepath = 'public/images/' . $this->original_name . $this->original_extension;
		$image->save(storage_path('app/' . $filepath));

		return $filepath;
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
