@extends('layouts.app')

@section('content')

<div class="container">

	<div class"row row-centered">


		@if($user)
		<div class="card card-block">
			<h4 class="card-title">Settings</h4>
			<p>No settings to be set</p>

		</div>

		<div class="card card-block">
			<h4 class="card-title">Account</h4>
			<p>No settings to be set</p>

			<div id="modal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
							<h4 class="modal-title">Delete account</h4>
						</div>
						<div class="modal-body">
							<p>
								Deleting your account will also remove all associated private data.
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<a href="{{ url('/user/delete/' . Auth::user()->getKey()) }}" class="btn btn-danger" role="button">Delete</a>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<a data-toggle="modal" data-target="#modal" href="#" class="btn btn-danger">Delete account</a>
			</div>
			@endif



	</div>

</div>

@endsection
