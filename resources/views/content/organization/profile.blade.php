@extends('layouts.app')

@section('content')


	@if($subject)

		<div class="card">
			<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
			<div class="card-block">
				<h4 class="card-title">{{ $subject->getName() }}</h4>
				<p class="card-body">
					This is the public organization page of {{ $subject->name }}.
				</p>
			</div>
		</div>

	@endif


@endsection
