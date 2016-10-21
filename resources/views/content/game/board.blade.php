@extends('layouts.app')

@section('content')

	<div class="container">

		@if($game->finished_at)

			@include('content.game.partials.played')

		@elseif($game->started_at)

			@include('content.game.partials.playing')

		@elseif($game->type)

			@include('content.game.partials.players')

		@else

			@include('content.game.partials.gametype')

		@endif

	</div>

@endsection
