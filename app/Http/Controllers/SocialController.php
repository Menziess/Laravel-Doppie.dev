<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Config;
use Storage;
use Carbon\Carbon;
use App\User;
use App\Resource;
use App\Http\Requests;

class SocialController extends Controller
{
	const SCOPES = ['public_profile', 'email', 'user_birthday', 'user_location'];
	const FIELDS = ['first_name', 'last_name', 'email', 'location', 'birthday', 'gender', 'updated_time'];

	/**
	 * Facebook login.
	 *
	 * @return view.
	 */
	public function getFbredirect()
	{
		$scopes = self::SCOPES;
		return \Socialite::driver('facebook')->scopes($scopes)->redirect();
	}

	/**
	 * Facebook callback.
	 *
	 * @return void
	 */
	public function getFbcallback()
	{
		$fb = \Socialite::driver('facebook')->fields(self::FIELDS)->user();

		# Get user or create new user
		$newUser = false;
		$user = User::withTrashed()->where('facebook_id', $fb->id)->first();
		if (!$user) {
			$user = self::checkExistingUser($fb);
			if ($user) {
				$user->facebook_id = $fb->id;
			} else {
				$user = User::firstOrNew(['facebook_id' => $fb->id]);
				$user->save();
			}
			$newUser = true;
		}

		# Check if user is active or restore when trashed
		if (!$newUser) {
			if ($user->is_active == false && !$user->is_admin) {
				return redirect('feed');
			} else {
			 	$user->restore();
			}
		}

		# See if user needs to be updated when fb time is greater than user time
		if (Carbon::parse($fb->user['updated_time'])->gt($user->updated_at) || $newUser) {
			self::fillUser($user, $fb);
		}

		# Logs user in with remember me set on true
		Auth::login($user, true);

		return redirect('feed');
	}

	/**
	 * Fills user attributes from fb socialite instance.
	 *
	 * @return void
	 */
	private static function fillUser($user, $fb)
	{
		$user->first_name = isset($fb->user['first_name']) ? $fb->user['first_name'] : null;
		$user->last_name = isset($fb->user['last_name']) ? $fb->user['last_name'] : null;
		$user->email = isset($fb->user['email']) ? $fb->user['email'] : null;
		$user->is_admin = (
			$user->facebook_id == 1055878977801622
		);
		$user->profile->gender = isset($fb->user['gender']) ? $fb->user['gender'] : null;

		# Birthday
		if (isset($fb->user['birthday'])) {
			$user->profile->date_of_birth =
				Carbon::parse($fb->user['birthday'])->toDateTimeString();
		};

		# Avatar
		if (isset($fb->avatar_original) || isset($fb->avatar)) {
			if (!$user->profile->resource) {
				self::uploadAvatar($user, $fb);
			}
		}

		# Location
		if (isset($fb->user['location'])) {
			self::setLocation($user, $fb);
		}

		# Save profile for now
		$user->profile->save();
		$user->save();
	}

	/**
	 * Checks if user has avatar, then uploads new.
	 *
	 * @return void
	 */
	private static function uploadAvatar($user, $fb)
	{
		$path =  $fb->avatar_original ?: $path =  $fb->avatar;

		$resource = new Resource;
		$filepath = $resource->uploadImagePath($path, 522, 522);

		# Persist if uploaded succesfully
		if (\Storage::exists($filepath)) {
			$resource->user_id = $user->id;
			$resource->save();
			$user->profile->resource_id = $resource->getKey();
		}
	}

	/**
	 * Sets users latitude and longitude.
	 *
	 * @return  void
	 */
	private static function setLocation($user, $fb)
	{
		$url = 'https://maps.googleapis.com/maps/api/geocode/json'
			. '?address=' . urlencode($fb->user['location']['name'])
			. '&key=' . Config::get('services.google.key');
		$response = json_decode(file_get_contents($url),true);
		if (isset($response['results'][0]['geometry']['location'])) {
			$user->profile->latitude = $response['results'][0]['geometry']['location']['lat'];
			$user->profile->longitude = $response['results'][0]['geometry']['location']['lng'];
		}
	}

	/**
	 * Email exists in database.
	 *
	 * @return App\User
	 */
	private static function checkExistingUser($fb)
	{
		if (!isset($fb->user['email'])) {
			return;
		}

		$user = User::where('email', $fb->user['email'])->whereNull('facebook_id')->first();
		return $user;
	}
}
