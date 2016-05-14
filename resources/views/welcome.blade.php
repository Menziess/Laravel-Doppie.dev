@extends('layouts.app')

@section('content')

	<div class="row">
		<h1 class="display-1">Lets grow something beautifull!</h1>
		<h2>(Click on the distracting cube-tree to begin)</h2>
			<a href="{{ url('register') }}" class="over round">
				<img src="{{ asset('img/growing.gif') }}" class="img-fluid center-block" alt="" />
			</a>
		</p>

	</div>

@endsection
