<div id="players" class="card shadow card-block m-t-2">
	<div class="row">
		<h2 class="card-title">{{ $game->type }}</h2>
		<p>
			<small>Created {{ $game->created_at->diffForHumans() }}</small>
		</p>

		@if ($game->type == 'Hartenjagen')
			@include('content.game.partials.players.hartenjagen')
		@elseif ($game->type == 'Klaverjassen')
			@include('content.game.partials.players.klaverjassen')
		@endif

	</div>
</div>
