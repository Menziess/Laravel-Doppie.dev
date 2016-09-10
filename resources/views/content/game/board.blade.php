@extends('layouts.app')

@section('content')

	<div class="container">

		@if($game->finished_at)

			<div class="card shadow">
				<div class="card-block">
					<h2 class="card-title">New Game</h2>
					@if($game->finished_at->addDays(1) < Carbon\Carbon::now())
						<p>
							The last game was played on {{ $game->finished_at->toFormattedDateString() }}
						</p>
					@endif
					<form style="display: inline-block;" method="POST" action="{{ url('game/create-game') }}">
						{!! csrf_field() !!}
						<button class="btn btn-warning-outline center-block" type="submit">Create New Game</button>
					</form>
				</div>
			</div>



			@include('content.game.partials.played')

		@elseif($game->started_at)

			@include('content.game.partials.playing')

		@else

			@include('content.game.partials.players')

		@endif

	</div>

@endsection
