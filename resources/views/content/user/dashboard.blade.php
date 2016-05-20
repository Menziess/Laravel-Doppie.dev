@extends('layouts.app')


@section('content')

<div class="container">

	@if($subject->users)

		@foreach($subject->users as $user)
			{{ $user->getName() . ' ' . $user->pivot->type }}<br/>
		@endforeach

	@endif

</div>

@endsection
