@extends('layouts.app')

@section('content')
<div class="container">

	<div class"row row-centered">

		<div class="card card-block">
			@if($user)
			<h4 class="card-title">Settings</h4>
				<p>No settings to be set</p>
				<a href="#" class="btn btn-primary">Don't press!</a>
			@endif
		</div>
	</div>

</div>
@endsection
