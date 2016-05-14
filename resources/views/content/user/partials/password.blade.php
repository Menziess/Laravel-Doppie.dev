<div id="password" class="card card-block">
	<div class="row">
		<h4 class="card-title">Password</h4>
		<div class="col-md-6 col-md-offset-3 col-centered">

			@if (Session::has('password'))
				<div class="alert alert-success" role="alert">
					{{ Session::get('password') }}
				</div>
			@endif

			<form id="form-password" class="form-horizontal" role="form" method="POST" action="{{ url('/user/password') }}">
				{!! csrf_field() !!}
				{{ method_field('PUT') }}

				<input name="id" value="{{ $subject->getKey() }}" type="hidden" class="form-control">

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon-password-1">Pass</span>
						<input name="password" type="password" class="form-control" placeholder="{{ $subject->password ? 'password set' : 'new password' }}" aria-describedby="basic-addon-password-1">
					</div>

					@if ($errors->has('password'))
						<div class="alert alert-warning" role="alert">
							{{ $errors->first('password') }}
						</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon-password-2">Pass</span>
						<input name="password_confirmation" type="password" class="form-control" placeholder="{{ $subject->password ? 'password set' : 'new password' }}" aria-describedby="basic-addon-password-2">
					</div>

					@if ($errors->has('password-confirmation'))
						<div class="alert alert-warning" role="alert">
							{{ $errors->first('password-confirmation') }}
						</div>
					@endif
				</div>

				<hr>

				<button class="btn btn-primary-outline center-block" type="submit">Update</button>
			</form>

		</div>
	</div>
</div>
