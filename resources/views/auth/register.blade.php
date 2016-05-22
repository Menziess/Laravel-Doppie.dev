@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="div-centered-large">
			<h1 class="display-3 hidden-sm-down p-y-2">Welcome aboard!</h1>
			<h3 class="hidden-md-up spacer">Welcome aboard!</h3>
		</div>
	</div>

	<br />

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
				Continue with Facebook
			</a>
			<p class="text-xs-center p-t-2">
				<i class="fa fa-info-circle"></i> We won't post anything on Facebook
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form id="form" class="form-horizontal" method="POST" action="{{ url('/register') }}">
				{!! csrf_field() !!}

				<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">First:</span>
						<input name="first_name" value="{{ old('first_name') }}" type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon1">
					</div>

					@if ($errors->has('first_name'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('first_name') }}
					</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon2">Last:</span>
						<input name="last_name" value="{{ old('last_name') }}" type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon2">
					</div>

					@if ($errors->has('last_name'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('last_name') }}
					</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<div class="input-group p-t-2">
						<span class="input-group-addon" id="basic-addon3">@</span>
						<input name="email" type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon3" value="{{ old('email') }}">
					</div>

					@if ($errors->has('email'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('email') }}
					</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon4">Pass</span>
						<input name="password" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon4">
					</div>

					@if ($errors->has('password'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('password') }}
					</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon5">Pass</span>
						<input name="password_confirmation" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon5">
						<span class="input-group-btn">
							<button class="btn btn-success" type="submit">Go</button>
						</span>
					</div>

					@if ($errors->has('password-confirmation'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('password-confirmation') }}
					</div>
					@endif
				</div>
			</form>

			<p class="text-xs-center">
				<a class="btn btn-link" href="{{ url('/terms') }}">Terms and conditions</a>
			</p>
		</div>
	</div>
</div>

@endsection


