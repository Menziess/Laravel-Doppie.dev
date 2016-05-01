@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
	<div class="row row-centered">
			<h1 class="display-4">Restore password</h1>

		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">

				<div class="panel-body padding-top">
					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
						{!! csrf_field() !!}

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								<div class="input-group padding-top">
									<span class="input-group-addon" id="basic-addon1">@</span>
									<input name="email" type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" value="{{ old('email') }}">
								<span class="input-group-btn">
									<!-- <button class="btn btn-primary" type="submit">Send!</button> -->
									<button class="btn btn-primary" type="button">Send!</button>
								</span>
								</div>

							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
