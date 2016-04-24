<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SocialController extends Controller
{
	/**
	 * Facebook login.
	 *
	 * @todo  this route is no longer needed
	 * @return view.
	 */
    public function getFbredirect()
    {
    	$scopes = ['public_profile', 'email', 'user_birthday'];
        return \Socialite::driver('facebook')->scopes($scopes)->redirect();
    }

    public function getFbcallback()
    {
        $user = \Socialite::driver('facebook')->user();
        dd($user);
    }
}
