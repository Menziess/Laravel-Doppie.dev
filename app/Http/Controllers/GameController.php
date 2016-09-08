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
    public function getShow($id)
    {
    	$users = User::all();
		$game = Game::findOrFail($id);
        $links = self::LINKS;

    	return view('content.game.board', compact('game', 'users', 'links'));
    }

    /*
     * Start game.
     */
    public function putStartGame()
    {
    	$game = Game::active()->orderBy('id', 'desc')->firstOrFail();
    	$game->start();

    	return redirect('/game');
    }

    /*
     * Saves the score of the game.
     */
    public function putSaveScore(Request $request)
    {
        $users = array_except($request->all(), ['_token', '_method']);

        if (!array_filter($users)) {
            return redirect()->to(\URL::previous() . '#bottom')->withErrors(['Please enter scores before pressing any buttons.']);
        }

        $game = Game::active()->orderBy('id', 'desc')->firstOrFail();

        return $game->saveScore($request, $users);
    }

    /*
     * Delete game.
     */
    public function deleteDeleteGame()
    {
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
