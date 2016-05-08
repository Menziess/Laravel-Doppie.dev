<div id="profile" class="card card-block">
	<div class="row">
		<h4 class="card-title">Profile</h4>
		<div class="col-md-6 col-md-offset-3 col-centered">

			@if (Session::has('profile'))
				<div class="alert alert-success" role="alert">
					{{ Session::get('profile') }}
				</div>
			@endif

			<form id="form-profile" class="form-horizontal" method="POST" action="{{ url('/user/profile') }}">
				{!! csrf_field() !!}
				{{ method_field('PUT') }}

				<input name="id" value="{{ $user->getKey() }}" type="hidden" class="form-control">

				<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">First:</span>
						<input name="first_name" value="{{ old('first_name') ?: $user->first_name }}" type="text" class="form-control" aria-describedby="basic-addon1">
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
						<input name="last_name" value="{{ old('last_name') ?: $user->last_name}}" type="text" class="form-control" aria-describedby="basic-addon2">
					</div>

					@if ($errors->has('last_name'))
					<div class="alert alert-warning" role="alert">
						{{ $errors->first('last_name') }}
					</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
					<div class="btn-group">
						<label class="radio-inline">
							<input type="radio" name="gender" value="male" {{ $user->profile->gender == 'male' ? 'checked' : '' }} />
							Male
						</label>
						<label class="radio-inline">
							<input type="radio" name="gender" value="female" {{ $user->profile->gender == 'female' ? 'checked' : '' }} />
							Female
						</label>
					</div>

					@if ($errors->has('gender'))
						<div class="alert alert-warning" role="alert">
							{{ $errors->first('gender') }}
						</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon3">@</span>
						<input name="email" value="{{ old('email') ?: $user->email ?: '' }}" type="email" class="form-control" aria-describedby="basic-addon3" >
					</div>

					@if ($errors->has('email'))
						<div class="alert alert-warning" role="alert">
							{{ $errors->first('email') }}
						</div>
					@endif
				</div>


				<hr>


				<button class="btn btn-primary-outline center-block" type="submit">Update</button>
			</form>
		</div>
	</div>
</div>
