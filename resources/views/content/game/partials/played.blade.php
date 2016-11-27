@if($game->type == \App\Game::HARTENJAGEN)
	@include('content.game.partials.played.hartenjagen')
@elseif($game->type == \App\Game::KLAVERJASSEN)
	@include('content.game.partials.played.klaverjassen')
@endif
