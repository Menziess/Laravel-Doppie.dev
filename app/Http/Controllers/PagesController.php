<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    public function getIndex()
    {
    	return view('welcome');
    }

    public function getTerms()
    {
    	return 'Terms and Conditions';
    }
}
