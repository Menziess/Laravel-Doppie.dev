@extends('layouts.app')

@section('content')

<div class="container">

	<div class"row row-centered">


		<div class="card card-block">
			@if($user)
			<h4 class="card-title">Settings</h4>

				@include('auth.user.upload')


				<p>No settings to be set</p>
				<a data-toggle="modal" data-target="#modal" href="#" class="btn btn-primary">Modal</a>
				<button type="button" href="{{ url('/user/delete/' . Auth::user()->getKey()) }}" data-method="delete" class="btn btn-danger">Delete account</button>
			@endif
		</div>


	</div>

</div>

@endsection
