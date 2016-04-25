<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Http\Requests;

class SocialController extends Controller
{
	const SCOPES = ['public_profile', 'email', 'user_birthday', 'user_location', 'user_hometown'];
	const FIELDS = ['first_name', 'last_name', 'location', 'birthday', 'gender'];

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
		$user = User::withTrashed()->where('facebook_id', $fb->id)->first();
		if (!$user) {
			$user = User::firstOrNew(['facebook_id' => $fb->id]);
		}

		# Check if user is active or restore when trashed
		if ($user->is_active === false) {
			abort(403, User::USER_IS_BLOCKED_BY_ADMIN);
		} elseif ($user->trashed()) {
			$user->restore();
		}

		self::fillUser($user, $fb);

		Auth::login($user);

		return redirect()->back();
	}

	/**
	 * Fills user attributes from fb socialite instance.
	 *
	 * @return void
	 */
	private static function fillUser($user, $fb)
	{
		$user->save();
	}
}
