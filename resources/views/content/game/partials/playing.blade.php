@if ($game->type == \App\Game::HARTENJAGEN)
	@include('content.game.partials.playing.hartenjagen')
@elseif ($game->type == \App\Game::KLAVERJASSEN)
	@include('content.game.partials.playing.klaverjassen')
@endif
