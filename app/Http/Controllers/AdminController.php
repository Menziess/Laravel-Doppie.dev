<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;

class AdminController extends Controller
{
    public function getIndex(Request $request)
    {
    	if (\Auth::guest() || !\Auth::user()->is_admin) {
    		return redirect()->action('HomeController@getIndex');
    	}

    	$users = User::orderBy('id', 'desc')->paginate(15);
    	return view('auth.admin.users', compact('users'));
    }
}
