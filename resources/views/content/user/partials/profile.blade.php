<div id="profile" class="card card-block">
	<h4 class="card-title">Profile</h4>

	<form id="form-profile" class="form-horizontal" role="form" method="POST" action="{{ url('/user/profile') }}">
		{!! csrf_field() !!}
		{{ method_field('PUT') }}

		<input name="id" value="{{ $user->getKey() }}" type="hidden" class="form-control">

		<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">First:</span>
				<input name="first_name" value="{{ old('first_name') ?: $user->first_name }}" type="text" class="form-control" aria-describedby="basic-addon1">
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
				<input name="last_name" value="{{ old('last_name') ?: $user->last_name}}" type="text" class="form-control" aria-describedby="basic-addon1">
			</div>

			@if ($errors->has('last_name'))
				<span class="help-block">
					<strong>{{ $errors->first('last_name') }}</strong>
				</span>
			@endif
		</div>

		<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
			<div class="btn-group ">
				<select class="form-control" id="sel1" form="form-profile" name="gender">
				@if($user->profile->gender == 'male' || old('gender') == 'male')
				<option value="male" selected>Male</option>
				<option value="female">Female</option>
				@else
				<option value="male">Male</option>
				<option value="female" selected>Female</option>
				@endif
				</select>
			</div>

		@if ($errors->has('gender'))
			<span class="help-block">
				<strong>{{ $errors->first('gender') }}</strong>
			</span>
		@endif
		</div>

		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">@</span>
				<input name="email" value="{{ old('email') ?: $user->email ?: '#' }}" type="email" class="form-control" aria-describedby="basic-addon1" >
			</div>

		@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
		@endif
		</div>

		<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">Location</span>
				@if($user->profile->latitude && $user->profile->longitude)
					<a href="https://www.google.nl/maps/@"{{ $user->profile->latitude }}","{{ $user->profile->longitude }}",15z?hl=en" target="blank">
					<input name="location" type="text" class="form-control" aria-describedby="basic-addon1" value="{{ old('location') ?: $user->profile->latitude . ' ' . $user->profile->longitude }}" readonly>
					</a>
				@else
					<input name="location" type="text" class="form-control" aria-describedby="basic-addon1" value="{{ old('location') }}" placeholder="Not set" readonly>
				@endif
			</div>

		@if ($errors->has('location'))
			<span class="help-block">
				<strong>{{ $errors->first('location') }}</strong>
			</span>
		@endif
		</div>

		<div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1">Birthday</span>
				<input name="birthday" required value="{{ old('birthday') ?: $user->profile->date_of_birth ? $user->profile->date_of_birth->toDateString() : ''}}" type="date" class="form-control" aria-describedby="basic-addon1">
			</div>

		@if ($errors->has('birthday'))
			<span class="help-block">
				<strong>{{ $errors->first('birthday') }}</strong>
			</span>
		@endif
		</div>


		<hr>

		<button class="btn btn-primary-outline" type="submit">Update</button>
	</form>
</div>
