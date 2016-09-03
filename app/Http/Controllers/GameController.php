<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Game;

class GameController extends Controller
{
    public function getIndex() {

    	$game = Game::active()->orderBy('id', 'desc')->first();

    	if (!$game) {
    		 $game = new Game();
    	}

    	return view('game', compact('game'));
    }
}
