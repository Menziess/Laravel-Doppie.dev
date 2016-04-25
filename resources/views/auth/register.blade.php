@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-centered">

		<div class="jumbotron jumbotron-fluid bg-faded">
			<div class="container">
			<h1 class="display-4">We're glad to have you on board!</h1>
				<div class="col-md-8 col-md-offset-2 col-centered padding-top">
					<div class="panel panel-default">
						<div class="panel-body">

							<!-- FACEBOOK LOGIN -->
							<div class="div-centered-small padding-top">
								<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
									Facebook
								</a>
							</div>

							<hr>

							<!-- REGISTER FLOW -->
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
										<span class="input-group-addon" id="basic-addon1">Password</span>
										<input name="password" type="password" class="form-control" aria-describedby="basic-addon1">
									</div>

								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
								</div>

								<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Password</span>
										<input name="password_confirmation" type="password" class="form-control" aria-describedby="basic-addon1">
										<span class="input-group-btn">
											<button class="btn btn-primary" type="submit"><i class="fa fa-btn fa-sign-in"></i>Go!</button>
										</span>
									</div>

								@if ($errors->has('password_confirmation'))
									<span class="help-block">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
								@endif
								</div>

							</form>

						</div>
					</div>
				</div>
			</div><!-- Inner Container -->
		</div><!-- Jumbotron -->
	</div><!-- Row -->
</div><!-- Container -->

@endsection


