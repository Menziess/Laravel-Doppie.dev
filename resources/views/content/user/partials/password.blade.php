

<div id="password" class="card card-block">
	<h4 class="card-title">Password</h4>

		<form id="form-password" class="form-horizontal" role="form" method="POST" action="{{ url('/user/password') }}">
			{!! csrf_field() !!}
			{{ method_field('PUT') }}

			<input name="id" value="{{ $user->getKey() }}" type="hidden" class="form-control">

			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">Pass</span>
					<input name="password" type="password" class="form-control" placeholder="{{ $user->password ? '********' : 'new password' }}" aria-describedby="basic-addon1">
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
					<input name="password_confirmation" type="password" class="form-control" placeholder="{{ $user->password ? '********' : 'new password' }}" aria-describedby="basic-addon1">
				</div>

			@if ($errors->has('password_confirmation'))
				<span class="help-block">
					<strong>{{ $errors->first('password_confirmation') }}</strong>
				</span>
			@endif
			</div>

			<hr>

			<button class="btn btn-primary-outline" type="submit">Update</button>
		</form>


</div>
