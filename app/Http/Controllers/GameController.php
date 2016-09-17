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
        $game = Game::findOrFail($id);
    	$users = User::all();
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
     * Gets round number of game.
     */
    public function getRound($nr = null)
    {
        $game = Game::active()->orderBy('id', 'desc')->first();
        if (!$game || !$nr) {
            abort(404, 'Not found, because this game has already been played.');
        }

        return view('content.game.row', compact('game', 'nr'));
    }

    public function putRound(Request $request, $nr = null)
    {
        $game = Game::active()->orderBy('id', 'desc')->first();
        if (!$game || !$nr) {
            abort(404, 'Not found, because this game has already been played.');
        }

        $users = array_except($request->all(), ['_token', '_method']);

        if (!array_filter($users)) {
            return redirect()->to(\URL::previous() . '#bottom')->withErrors(['Please enter scores before pressing any buttons.']);
        }

        $scores = $game->getData('scores');
        foreach($users as $user => $score) {
            $scores->{$nr}->{$user} = $score;
        }

        $game->setData('scores', $scores);
        $game->save();

        return redirect('game');
    }

    /*
     * Creates a new game.
     */
    public function postCreateGame(Request $request)
    {
        $game = Game::active()->orderBy('id', 'desc')->first();
        if (!$game) {
            $game = new Game();
            $game->save();
        } else {
            $request->session()->flash('message', 'A game was already created.');
        }

        return redirect('/game');
    }

    /*
     * Start game.
     */
    public function putStartGame(Request $request)
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
	public function postAddUsers(Request $request)
	{
        $game = Game::active()->orderBy('id', 'desc')->firstOrFail();
        $users = array_except($request->all(), ['_token', '_method']);
        \Session::set('time-added', $users);
        $users = array_keys(array_sort($users, function($value) {
            return $value;
        }));
		$game->addPlayersById($users);

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
