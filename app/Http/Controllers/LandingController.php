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
        $nrHartenjagen = \App\Game::where('type', \App\Game::HARTENJAGEN)->whereNotNull('finished_at')->count();

    	return view('landing', compact('links', 'nrHartenjagen'));
    }

	/*
	 * Gets terms and conditions page.
	 */
    public function getTerms()
    {
    	return 'Terms and Conditions';
    }
}
