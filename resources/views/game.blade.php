@extends('layouts.app')

@section('content')

	@if($game)

		{{ $game }}

		@foreach($game->users as $user)

			{{ $user }}

		@endforeach

	@endif

@endsection
