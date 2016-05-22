@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="div-centered-large">
			<h1 class="display-3 hidden-sm-down p-y-2">Well hello there!</h1>
			<h3 class="hidden-md-up spacer">Well hello there!</h3>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
				Continue with Facebook
			</a>
			<p class="text-xs-center padding-top">
				<i class="fa fa-info-circle"></i> We won't post anything on Facebook
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
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

	<hr />

	<div class="row m-t-3">
		<a href="{{ url('/register') }}" class="btn btn-secondary m-t-3">
			Register
		</a>
	</div>

	<div class="m-t-3">
	</div>

</div>


@endsection
