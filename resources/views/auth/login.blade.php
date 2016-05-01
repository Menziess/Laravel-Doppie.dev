@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row row-centered">

		<div class="jumbotron jumbotron-fluid bg-faded">
			<div class="container">
			<h1 class="display-4">Well hello there!</h1>

				<div class=
					"col-xs-10 col-sm-8 col-md-8 col-lg-6
					col-xs-offset-1 col-sm-offset-2 col-md-offset-2 col-lg-offset-3
					col-centered padding-top"
				>
					<div class="panel panel-default">
						<div class="panel-body">

							<!-- FACEBOOK LOGIN -->
							<a href="{{ url('/facebook/fbredirect') }}" class="btn btn-social btn-facebook btn-block">
								Continue with Facebook
							</a>
							<p class="text-xs-center padding-top">
								<i class="fa fa-question-circle"></i> We don't post anything on Facebook
							</p>
							<!-- FACEBOOK LOGIN -->


							<hr>


							<!-- LOGIN FORM -->
							<p class="text-xs-center">
								Login with email and password
							</p>
							<p>
							<button class="btn btn-secondary btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
							Login
							</button>
							</p>
							<div class="collapse" id="collapseExample">

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
												<button class="btn btn-primary" type="submit">Login</button>
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
							</div>
							<!-- LOGIN FORM -->


							<hr>


							<!-- REGISTER BUTTON -->
							<p class="text-xs-center">
								You can also register using Facebook
							</p>
							<a href="{{ url('/register') }}" class="btn btn-secondary btn-block">
								Register
							</a>
							<!-- REGISTER BUTTON -->

						</div>
					</div>
				</div>
			</div><!-- Inner container -->
		</div><!-- Jumbotron -->
	</div><!-- Row -->
</div><!-- Container -->

@endsection
