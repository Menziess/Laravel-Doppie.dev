@extends('layouts.app')

@section('content')

<div class="jumbotron jumbotron-fluid bg-faded">

	<div class="container">

	<h1 class="display-4">Well hello there!</h1>

		<div class="col-md-6 col-md-offset-3 col-centered padding-top">

			<p class="text-xs-center">
				Login with Facebook:
			</p>

			<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
				Continue with Facebook
			</a>

			<p class="text-xs-center padding-top">
				<i class="fa fa-info-circle"></i> We won't post anything on Facebook
			</p>


			<hr/>


			<p class="text-xs-center">
				Login with email and password:
			</p>

			<form id="form" class="form-horizontal" method="POST" action="{{ url('/login') }}">
				{!! csrf_field() !!}

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">@</span>
						<input name="email" type="email" class="form-control" aria-describedby="basic-addon1" value="{{ old('email') }}">
						<span class="input-group-addon bg-secondary hidden-xs hidden-xs-down">
					    	<input name="remember" type="radio" aria-label="Radio button for following text input"> Remember
						</span>
					</div>

					@if ($errors->has('email'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('email') }}
					</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon2">Pass</span>
						<input name="password" type="password" class="form-control" aria-describedby="basic-addon2">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit">Login</button>
						</span>
					</div>

					@if ($errors->has('password'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('password') }}
					</div>
					@endif
				</div>

				<div class="hidden-sm-up">
					<input name="remember" type="radio" aria-label="Radio button for following text input"> Remember
				</div>
			</form>

			<p class="text-xs-center">
				<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
			</p>


			<hr>


			<a href="{{ url('/register') }}" class="btn btn-secondary btn-block">
				Register
			</a>


		</div>

	</div>

</div>

@endsection
