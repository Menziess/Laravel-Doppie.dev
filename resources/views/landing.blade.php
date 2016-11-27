@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="div-centered-large">
			<h1 class="display-3 hidden-sm-down spacer p-y-2">{{ Config::get('app.name') }}</h1>
			<h3 class="hidden-md-up spacer">{{ Config::get('app.name') }}</h3>
		</div>

		<i class="fa fa-btn fa-angle-down m-y-2" style="font-size: 32px;"></i>
	</div>

	<div id="landing-project" class="card m-y-2 shadow">
		<div class="card-header touchable" data-toggle="collapse" href="#project2" aria-expanded="false" aria-controls="header">
			<h4 class="card-title unselectable">Klaverjassen</h4>
		</div>

		<div id="project2" class="collapse in">
			<div class="card-block">
				<div class="row">

					<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 left">
						<img id="picture" src="{{ asset('img/games/clover.png') }}" class="profile-picture-small"
							alt="" data-href="#" data-content="" rel="popover" data-placement="right" data-original-title=""
							data-trigger="hover" width="150" height="150">
					</div>

					<div class="col-xs-18 col-sm-6 col-md-6 col-lg-6 left">
					<h4 class="card-title">To Do</h4>
					<p class="card-body">
						<ul class="no-dots">
							<li><i class="fa fa-btn fa-minus"></i>&#09;Create statistics page</li>
							<li><i class="fa fa-btn fa-minus"></i>&#09;Add shuffler</li>
							<br/>
							<li><i class="fa fa-btn fa-check text-success"></i>&#09;Add Klaverjassen</li>
						</ul>
					</p>
					</div>

				</div>
			</div>
		</div>

		<div class="card-footer touchable">
			<div id="progress" class="p-t-1">
				<a data-toggle="collapse" href="#project2" aria-expanded="false" aria-controls="header">
				<progress class="progress progress-success" value="33" max="100"></progress>
				</a>
			</div>
		</div>
	</div>

	<div id="landing-project" class="card m-y-2 shadow">
		<div class="card-header touchable" data-toggle="collapse" href="#project1" aria-expanded="false" aria-controls="header">
			<h4 class="card-title unselectable">Hartenjagen</h4>
		</div>

		<div id="project1" class="collapse in">
			<div class="card-block">
				<div class="row">

					<div class="col-xs-18 col-sm-6 col-md-4 col-lg-4 left">
						<img id="picture" src="{{ asset('img/games/heart.png') }}" class="profile-picture-small"
							alt="" data-href="#" data-content="" rel="popover" data-placement="right" data-original-title=""
							data-trigger="hover" width="150" height="150">
					</div>

					<div class="col-xs-18 col-sm-6 col-md-6 col-lg-6 left">
					<h4 class="card-title">To Do</h4>
					<p class="card-body">
						<ul class="no-dots">
							<li><i class="fa fa-btn fa-check text-success"></i>&#09;Add client side validation</li>
							<li><i class="fa fa-btn fa-check text-success"></i>&#09;Add new player picker</li>
							<li><i class="fa fa-btn fa-check text-success"></i>&#09;Add shuffler</li>
							<li><i class="fa fa-btn fa-check text-success"></i>&#09;Add game scores</li>
							<li><i class="fa fa-btn fa-check text-success"></i>&#09;Build in game ownership</li>
						</ul>
					</p>
					</div>

				</div>
			</div>
		</div>

		<div class="card-footer touchable">
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
		</div>

	<div class="row">
		<div class="col-xs-12">
			<p class="lead">
			Hi, my name is <span class="text-success">Stefan</span> and this is my personal site.
			<br /><br>
			I'm a real workoholic, a creator and a perfectionist.
			I've been a marine for five years, and I'm currently studying Software Engineering.
			<br />
			I like beer, travelling, sports and programming &#60;&#47;&#62;.
			<br />
			Feel free to use this app.
			</p>
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
