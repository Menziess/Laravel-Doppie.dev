@extends('layouts.app')

@section('content')

<div class="container">

	<div class"row row-centered">


		<div class="card card-block">
			<h4 class="card-title">Picture</h4>

			<div id="modal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
							<h4 class="modal-title">Upload</h4>
						</div>
						<div class="modal-body">
							<p> // </p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary-outline" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary-outline">Save</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="row margin-bottom-20">
				<div class="col-md-3">
				@if($user && $user->profile->resource)
				<img src="{{ asset('storage/images/' . $user->profile->resource->original_name . $user->profile->resource->original_extension) }}" data-toggle="modal" data-target="#modal" class="img-circle profile-picture-small" width="400"  alt="" >
				@else
				<img src="{{ asset('img/placeholder.jpg') }}" data-toggle="modal" data-target="#modal" class="img-circle width-200 profile-picture-small" alt="" >
				@endif
				</div>
			</div>
		</div>

		<div class="card card-block">
			@if($user && $user->profile)
			<h4 class="card-title">Profile</h4>
			<div class="row margin-bottom-20">
				<div class="col-md-7">

				<form id="form" class="form-horizontal" role="form" method="POST" action="{{ url('/user/profile') }}">
					{!! csrf_field() !!}
					{{ method_field('PUT') }}

					<input name="id" value="{{ $user->getKey() }}" type="hidden" class="form-control">

					<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">First:</span>
							<input name="first_name" required value="{{ $user->first_name }}" type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon1">
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
							<input name="last_name" required value="{{ $user->last_name }}" type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon1">
						</div>

						@if ($errors->has('last_name'))
							<span class="help-block">
								<strong>{{ $errors->first('last_name') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">@</span>
							<input name="email" required type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" value="{{ $user->email ?: '#' }}">
						</div>

					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
					</div>

					<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
						<div class="btn-group">
							<select class="form-control" id="sel1" form="form" name="gender">
							<option value="male">Male</option>
							<option value="female">Female</option>
							</select>
						</div>

					@if ($errors->has('gender'))
						<span class="help-block">
							<strong>{{ $errors->first('gender') }}</strong>
						</span>
					@endif
					</div>

					<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Location</span>
							@if($user->profile->latitude && $user->profile->longitude)
								<a href="https://www.google.nl/maps/@"{{ $user->profile->latitude }}","{{ $user->profile->longitude }}",15z?hl=en" target="blank">
								<input name="location" type="text" class="form-control" aria-describedby="basic-addon1" value="{{ $user->profile->latitude . ' ' . $user->profile->longitude }}" readonly>
								</a>
							@else
								<input name="location" type="text" class="form-control" aria-describedby="basic-addon1" value="Not set" readonly>
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
							<input name="birthday" required type="date" class="form-control" aria-describedby="basic-addon1" value="{{ $user->profile->date_of_birth ? $user->profile->date_of_birth->toDateString() : '' }}">
						</div>

					@if ($errors->has('birthday'))
						<span class="help-block">
							<strong>{{ $errors->first('birthday') }}</strong>
						</span>
					@endif
					</div>

					<button class="btn btn-primary-outline" type="submit">Update</button>
				</form>


				</div>
			</div>
			@endif
		</div>

		@if(Auth::user()->is_admin)
		@include('auth.admin.panel')
		@endif


	</div>

</div>

@endsection

