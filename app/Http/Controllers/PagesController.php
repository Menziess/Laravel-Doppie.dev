<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
	/*
	 * Gets landing page.
	 */
    public function getIndex()
    {
    	return view('welcome');
    }

	/*
	 * Gets terms and conditions page.
	 */
    public function getTerms()
    {
    	return 'Terms and Conditions';
    }
}
