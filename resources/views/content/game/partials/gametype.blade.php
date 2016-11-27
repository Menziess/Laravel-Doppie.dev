<div class="card shadow m-t-3">
	<div class="card-block">
		<h2 class="card-title">New Game</h2>
		<small>Created {{ $game->created_at->diffForHumans() }}</small>
		@include('errors.feedback')
		<form style="display: inline-block;" method="POST" action="{{ url('game/set-type') }}">
			{!! csrf_field() !!}
			{{ method_field('PUT') }}
			<img class="card-img-top"
				style="width: 3em; margin: 1em;"
				src="{{ asset('img/games/heart.png') }}"
				alt="Game type">
			<input name="type" value="Hartenjagen" hidden="hidden">
			<button class="btn btn-primary-outline center-block" type="submit">Hartenjagen</button>
		</form>
		<form style="display: inline-block;" method="POST" action="{{ url('game/set-type') }}">
			{!! csrf_field() !!}
			{{ method_field('PUT') }}
			<img class="card-img-top"
				style="width: 3em; margin: 1em"
				src="{{ asset('img/games/clover.png') }}"
				alt="Game type">
			<input name="type" value="Klaverjassen" hidden="hidden">
			<button class="btn btn-primary-outline center-block" type="submit">Klaverjassen</button>
		</form>
	</div>
</div>
