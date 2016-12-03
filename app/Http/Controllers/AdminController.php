<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Auth;
use App\Game;
use App\User;
use App\Project;
use App\Organization;
use App\Http\Requests;

class AdminController extends Controller
{
	/*
	 * Get admin dashboard.
	 */
	public function getIndex(Request $request)
	{
		$input = $request->search;
		$search = '%' . $input . '%' ?: '%';
		$links = self::LINKS;
		$subject = Auth::user();
		$games = null;
		$users = null;
		if ($request->has('viewGames')) {
			$games = Game::withTrashed()
				->orderBy('id', 'desc')->paginate();
		} else {
			$users = User::withTrashed()
				->where('first_name', 'like', $search)
				->orWhere('last_name', 'like', $search)
				->orWhere('email', 'like', $search)
				->orderBy('id', 'desc')->paginate();
		}

		return view('content.all.list', compact('games', 'users', 'subject', 'links', 'input'));
	}

	/*
	 * Show games.
	 */
	public function getGames(Request $request)
	{
		$request->request->add(['viewGames' => true]);
		return $this->getIndex($request);
	}

	/*
	 * Show users.
	 */
	public function getUsers(Request $request)
	{
		$request->request->add(['viewUsers' => true]);
		return $this->getIndex($request);
	}

	/*
	|--------------------------------------------------------------------------
	| User routes
	|--------------------------------------------------------------------------
	|
	| For getting and modifying user information as a administrator.
	|
	*/

	/*
	 * Get user settings by id.
	 */
	public function getUser($id)
	{
		$links = self::LINKS;
		$subject = User::withTrashed()->findOrFail($id);
		return view('content.user.settings', compact('subject', 'links'));
	}

	/*
	 * Gets game by id.
	 */
    public function getGame($id)
    {
        $game = Game::withTrashed()->findOrFail($id);
    	$users = User::orderBy('xp', 'desc')->get();
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
	 * Grant admin rights.
	 */
	public function putEnableAdmin($id)
	{
		User::withTrashed()->findOrFail($id)->makeAdmin(true);
		return redirect()->to(\URL::previous() . '#admin');
	}

	/*
	 * Revoke admin rights.
	 */
	public function putDisableAdmin($id)
	{
		User::withTrashed()->findOrFail($id)->makeAdmin(false);
		return redirect()->to(\URL::previous() . '#admin');
	}

	/*
	 * Activate user by id.
	 */
	public function putActivateUser($id)
	{
		User::withTrashed()->findOrFail($id)->activate();
		return redirect()->to(\URL::previous() . '#permissions');
	}

	/*
	 * Deactivate user by id.
	 */
	public function putDeactivateUser($id)
	{
		User::withTrashed()->findOrFail($id)->deactivate();
		return redirect()->to(\URL::previous() . '#permissions');
	}
}
