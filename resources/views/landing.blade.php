@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="div-centered-large">
			<h1 class="display-3 hidden-sm-down spacer p-y-2">Lets simplify project management!</h1>
			<h3 class="hidden-md-up spacer">Lets simplify project management!</h3>
		</div>

		<i class="fa fa-btn fa-angle-down m-y-2" style="font-size: 32px;"></i>
	</div>

	<div id="landing-project" class="card m-y-2 shadow">
		<div class="card-header" data-toggle="collapse" href="#project1" aria-expanded="false" aria-controls="header">
			<h4 class="card-title unselectable">Project - Walk on the moon!</h4>
		</div>

		<div id="project1" class="collapse">
			<div class="card-block">
				<div class="row">

					<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 left">
						<img id="picture" src="{{ asset('img/landing.gif') }}" class="img-circle profile-picture-small"
							alt="" href="#" data-content="" rel="popover" data-placement="right" data-original-title=""
							data-trigger="hover" width="150" height="150">
					</div>

					<div class="col-xs-18 col-sm-6 col-md-6 col-lg-6 left">
					<h4 class="card-title">Walk on the moon!</h4>
					<p class="card-body">
						<ul class="no-dots">
							<li class="text-success"><i class="fa fa-btn fa-check"></i>Graduate as astronaut</li>
							<li><i class="fa fa-btn fa-minus"></i>&#09;Buy a spaceship</li>
							<li><i class="fa fa-btn fa-minus"></i>&#09;Start rocket engines</li>
						</ul>
						Hi, my name is Stefan and this is my personal site.
						<br />
						I'm a real workoholic, a creator and a perfectionist.
						I've been a marine for five years, and I'm currently studying Software Engineering.
						I like beer, travelling, sports and programming.
					</p>
					</div>

				</div>
			</div>
		</div>

		<div class="card-footer">
			<div id="progress" class="p-t-1">
				<a data-toggle="collapse" href="#project1" aria-expanded="false" aria-controls="header">
				<progress class="progress progress-success" value="33" max="100"></progress>
				</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div>
		<i class="fa fa-btn fa-angle-down m-y-2" style="font-size: 32px;"></i>
		</div>

		<a href="{{ url('/register') }}" class="btn btn-secondary m-y-2">
			Register
		</a>
	</div>

	<div class="spacer"></div>
</div>

@endsection
