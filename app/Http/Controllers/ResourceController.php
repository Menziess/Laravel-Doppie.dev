<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;

class ResourceController extends Controller
{
	/**
	 * Returns the picture of a user.
	 *
	 * @param  int $userID
	 * @return Image
	 */
   	public function picture($userID)
	{
		$resource = User::find($userID)->profile->resource;
		$path = $resource ? storage_path() . '/app/public/images/' . $resource->original_name . $resource->original_extension : null;
		return response()->file($path);
	}
}
