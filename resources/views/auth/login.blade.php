@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row row-centered">

		<div class="jumbotron jumbotron-fluid bg-faded">
			<div class="container">
			<h1 class="display-4">Well hello there!</h1>

				<div class="col-md-8 col-md-offset-2 col-centered padding-top">
					<div class="panel panel-default">
						<div class="panel-body">

							<!-- FACEBOOK LOGIN -->
							<div class="div-centered-large padding-top">
								<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
									Continue with Facebook
								</a>
							</div>

							<hr>

							<!-- LOGIN FLOW -->
							<form id="form" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
								{!! csrf_field() !!}
								<p class="text-xs-center">Alternatively...</p>

								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">@</span>
										<input name="email" type="email" class="form-control" aria-describedby="basic-addon1" value="{{ old('email') }}">
										<span class="input-group-addon bg-secondary hidden-xs hidden-xs-down">
									    	<input name="remember" type="radio" aria-label="Radio button for following text input"> Remember
										</span>
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
										<input name="password" type="password" class="form-control" aria-describedby="basic-addon1">
										<span class="input-group-btn">
											<button class="btn btn-primary" type="submit"><i class="fa fa-btn fa-sign-in"></i>Login!</button>
										</span>
									</div>

								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
								</div>

								<div class="hidden-sm-up">
									<input name="remember" type="radio" aria-label="Radio button for following text input"> Remember
								</div>
								<p class="text-xs-center">
									<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
								</p>
							</form>

							<hr>


							<!-- FACEBOOK LOGIN -->
							<div class="div-centered-large padding-top">
								<a href="{{ url('/register') }}" class="btn btn-secondary btn-block">
									Register
								</a>
							</div>
						</div>
					</div>
				</div>
			</div><!-- Inner container -->
		</div><!-- Jumbotron -->
	</div><!-- Row -->
</div><!-- Container -->

@endsection
