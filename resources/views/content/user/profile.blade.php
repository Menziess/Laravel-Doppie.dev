@extends('layouts.app')

@section('content')

<div class="container">

	@if($subject && $subject->profile)

		Level: {{ $subject->getLevel() }}
		Next level: {{ $subject->getXpNext() }}

		<div class="card card-block">
			<div class="row">
				<div class="col-md-4">
					<h4 class="card-title">{{ $subject->getName() }}</h4>

					<div class="row margin-bottom-20">
						<img src="{{ asset($subject->getPicture()) }}" class="img-circle profile-picture-small center-block" alt="">
					</div>

				</div>

				<div class="col-md-8 text-xs-left">
					<h4 class="card-title">Statistics</h4>
					To be added...
				</div>
			</div>
		</div>


	@endif

</div>

@endsection
