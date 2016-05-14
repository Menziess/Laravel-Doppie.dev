@extends('layouts.app')

@section('content')

	<div class="row">
		<h1 class="display-1 hidden-xs-down">Lets build something beautifull!</h1>
		<h3 class="hidden-sm-up">Lets build something beautifull!</h3>
		<a href="{{ url('register') }}" class="over round">
			<img src="{{ asset('img/landing.gif') }}" class="img-fluid center-block" alt="" />
		</a>
	</div>

@endsection
