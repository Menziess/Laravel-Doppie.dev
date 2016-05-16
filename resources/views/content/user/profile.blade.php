@extends('layouts.app')


@section('content')

<div class="container">

	@if($subject->projects)

		@foreach($subject->projects as $project)

		<div class="card">
			<div class="card-header" data-toggle="collapse" href="#project{{ $project->id }}" aria-expanded="false" aria-controls="header">
				<h4 class="card-title unselectable">Project - {{ $project->getName() }}</h4>
			</div>

			<div id="project{{ $project->id }}" class="collapse">
				<div class="card-block">
					<div class="row row-centered">

						<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
						<a href="{{ url($project->getProfileUrl()) }}" class="over round">
							<img id="picture" src="{{ asset($project->getPicture()) }}" class="img-circle profile-picture-small" alt="" href="#" data-content="" rel="popover" data-placement="right" data-original-title="" data-trigger="hover">
						</a>
						</div>

						<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 col-centered">
						<h4 class="card-title">{{ $project->getName() }}</h4>
						<p class="card-body">{{ $project->header }}</p>
						</div>

					</div>
				</div>
			</div>

			<div class="card-footer">
				<div id="progress" class="padding-top div-centered-large">
					<a data-toggle="collapse" href="#project{{ $project->id }}" aria-expanded="false" aria-controls="header">
					<progress class="progress progress-success" value="{{ $project->getXp() }}" max="100"></progress>
					</a>
				</div>
			</div>
		</div>

		@endforeach

	@endif

</div>

@endsection
