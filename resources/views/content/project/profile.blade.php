@extends('layouts.app')

@section('content')

<div class="container">

	@if($subject)

		<div class="card">
			<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
			<div class="card-block">
				<h4 class="card-title">{{ $subject->getName() }}</h4>
				<p class="card-body">
					This is project {{ $subject->name }}.
				</p>
			</div>
		</div>
	@endif

</div>

@endsection
