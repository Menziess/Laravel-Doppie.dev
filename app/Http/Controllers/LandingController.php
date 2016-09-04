<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LandingController extends Controller
{
	/*
	 * Gets landing page.
	 */
    public function getIndex()
    {
        $links = self::LINKS;

    	return view('landing', compact('links'));
    }

	/*
	 * Gets terms and conditions page.
	 */
    public function getTerms()
    {
    	return 'Terms and Conditions';
    }
}
