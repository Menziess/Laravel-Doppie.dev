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
    	return view('landing');
    }

	/*
	 * Gets terms and conditions page.
	 */
    public function getTerms()
    {
    	return 'Terms and Conditions';
    }
}
