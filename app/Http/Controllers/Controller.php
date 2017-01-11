<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    const LINKS = [
		['title' => 'Game', 'href' => '/game', 'text' => ''],
		['title' => 'Scores', 'href' => '/scores', 'text' => ''],
		['title' => 'Leaderboards', 'href' => '/leaderboards', 'text' => ''],
	];

    /**
	 * A generic empty response that tells nothing but success.
	 * Mostly used for the options route to enable cors.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function actionOk()
	{
		return new Response();
	}

	/**
	 * A generic response that tells the client it's current action cannot be found.
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 * @return void
	 */
	public function actionNotFound()
	{
		throw new NotFoundHttpException('The requested action was not found.');
	}
}
