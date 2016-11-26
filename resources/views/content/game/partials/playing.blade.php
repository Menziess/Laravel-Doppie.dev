@if ($game->type == 'Hartenjagen')
	@include('content.game.partials.playing.hartenjagen')
@elseif ($game->type == 'Klaverjassen')
	@include('content.game.partials.playing.klaverjassen')
@endif
