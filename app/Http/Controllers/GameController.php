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

    	$game = Game::orderBy('id', 'desc')->first();

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
        $subject = Auth::user();
        $links = self::LINKS;

        if ($game->finished_at) {
            $win_scores = $game->getData('winners');
            $lose_scores = $game->getData('losers');
            $winning_users = User::whereIn('id', array_keys((array) $win_scores))->get();
            $losing_users = User::whereIn('id', array_keys((array) $lose_scores))->get();

            $winners = $winning_users->map(function ($user) use ($win_scores) {
                return ['winner' => $user, 'points' => $win_scores->{$user->id}];
            });

            $losers = $losing_users->map(function ($user) use ($lose_scores) {
                return ['loser' => $user, 'points' => $lose_scores->{$user->id}];
            });
        }

    	return view('content.game.board', compact('winners', 'losers', 'subject', 'game', 'users', 'links'));
    }

    /*
     * Creates a new game.
     */
    public function postCreateGame()
    {
        $game = new Game();
        $game->save();

        return redirect('/game');
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
        $game->setData('deleted_by', Auth::user()->id);
        $game->save();
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
