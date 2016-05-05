@extends('layouts.app')

@section('content')

<div class="jumbotron jumbotron-fluid bg-faded">

	<div class="container">

	<h1 class="display-4">Welcome aboard!</h1>

		<div class="col-md-6 col-md-offset-3 col-centered padding-top">

			<p class="text-xs-center">
				Register with Facebook:
			</p>
			<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
				Continue with Facebook
			</a>
			<p class="text-xs-center padding-top">
				<i class="fa fa-info-circle"></i> We won't post anything on Facebook
			</p>


			<hr>


			<p class="text-xs-center">
				Register your account:
			</p>
			<form id="form" class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
				{!! csrf_field() !!}

				<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">First:</span>
						<input name="first_name" value="{{ old('first_name') }}" type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon1">
					</div>

					@if ($errors->has('first_name'))
						<span class="help-block">
							<strong>{{ $errors->first('first_name') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Last:</span>
						<input name="last_name" value="{{ old('last_name') }}" type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon1">
					</div>

					@if ($errors->has('last_name'))
						<span class="help-block">
							<strong>{{ $errors->first('last_name') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<div class="input-group padding-top">
						<span class="input-group-addon" id="basic-addon1">@</span>
						<input name="email" type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" value="{{ old('email') }}">
					</div>

				@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				@endif
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Pass</span>
						<input name="password" type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1">
					</div>

				@if ($errors->has('password'))
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				@endif
				</div>

				<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Pass</span>
						<input name="password_confirmation" type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit">Go</button>
						</span>
					</div>

				@if ($errors->has('password_confirmation'))
					<span class="help-block">
						<strong>{{ $errors->first('password_confirmation') }}</strong>
					</span>
				@endif
				</div>
			</form>

			<p class="text-xs-center">
				<a class="btn btn-link" href="{{ url('/terms') }}">Terms and conditions</a>
			</p>


			<hr>



			<a href="{{ url('/login') }}" class="btn btn-secondary btn-block">
				Back to Login
			</a>

		</div>
	</div>
</div>

@endsection


