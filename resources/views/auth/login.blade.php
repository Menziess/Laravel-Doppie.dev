@extends('layouts.app')

@section('content')

<div class="container">

	<div class="div-centered-large">
		<h1 class="display-3 hidden-xs-down padding-top">Well hello there!</h1>
		<h1 class="display-4 hidden-sm-up padding-top">Well hello there!</h1>
	</div>

	<br />

	<div class="row margin-top">
		<div class="col-md-6 col-md-offset-3 col-centered">
			<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
				Continue with Facebook
			</a>
			<p class="text-xs-center padding-top">
				<i class="fa fa-info-circle"></i> We won't post anything on Facebook
			</p>
		</div>
	</div>

	<div class="row margin-top">
		<div class="col-md-6 col-md-offset-3 col-centered">
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
							<button class="btn btn-success" type="submit">Login</button>
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
		</div>
	</div>

	<hr class="styled" />

	<div class="row margin-top">
		<a href="{{ url('/register') }}" class="btn btn-secondary margin-top">
			Register
		</a>
	</div>

	<div class="margin-top">
	</div>

</div>


@endsection
