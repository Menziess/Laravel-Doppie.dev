<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Game;
use App\User;

class GameController extends Controller
{
	/*
	 * Gets game page.
	 */
    public function getIndex() {

    	$game = Game::active()->orderBy('id', 'desc')->first();

    	if (!$game) {
    		 $game = new Game();
    		 $game->save();
    	}

    	return $this->getShow($game->id);
    }

    /*
	 * Gets game by id.
	 */
    public function getShow($id) {
    	$users = User::all();
		$game = Game::findOrFail($id);
        $links = self::LINKS;
        $maxPoints = 50;
        $maxPointsRound = count($game->users) > 4 ? count($game->users - 4) * 2 + 15 : 15;

    	return view('content.game.board', compact('game', 'users', 'links', 'maxPoints', 'maxPointsRound'));
    }

    /*
     * Start game.
     */
    public function putStartGame() {
    	$game = Game::active()->orderBy('id', 'desc')->firstOrFail();
    	$game->start();

    	return redirect('/game');
    }

    /*
     * Delete game.
     */
    public function deleteDeleteGame() {
    	$game = Game::active()->orderBy('id', 'desc')->firstOrFail();
    	$game->delete();

    	return redirect('/game');
    }

    /*
	 * Add user by id.
	 */
	public function putAddUser($id)
	{
		$user = User::withTrashed()->findOrFail($id);
		$game = Game::active()->orderBy('id', 'desc')->firstOrFail();

		$game->addPlayer($user);

		return redirect()->to(\URL::previous() . '#players');
	}

	/*
	 * Remove user by id.
	 */
	public function putRemoveUser($id)
	{
		$user = User::withTrashed()->findOrFail($id);
		$game = Game::active()->orderBy('id', 'desc')->firstOrFail();

		$game->removePlayer($user);

		return redirect()->to(\URL::previous() . '#players');
	}
}
