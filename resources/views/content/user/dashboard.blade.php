@extends('layouts.app')


@section('content')

<div class="container">

	@if($subject->users)

		Followers:
		@foreach($subject->followers as $follower)
			{{ $follower->getName() . ' ' . $follower->pivot->type }}<br/>
		@endforeach

		Donators:
		@foreach($subject->donators as $donator)
			{{ $donator->getName() . ' ' . $donator->pivot->type }}<br/>
		@endforeach

	@endif

</div>

@endsection
