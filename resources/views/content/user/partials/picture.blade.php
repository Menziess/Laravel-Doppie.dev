<div id="picture" class="card shadow card-block">
	<div class="row">
		<h4 class="card-title">Picture</h4>
		<div class="col-md-6 col-md-offset-3 col-centered">

			<div id="modal-upload" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
							<h4 class="modal-title">Upload</h4>
						</div>

						<form id="form-picture" class="form-horizontal" method="POST" action="{{ url('/user/picture') }}" enctype="multipart/form-data">
							{!! csrf_field() !!}

							<input name="id" value="{{ $subject->getKey() }}" type="hidden" class="form-control">

							<div class="modal-body">
								<div class="form-group{{ $errors->has('file') ? ' has-error' : '' }} div-centered-small">
									<p>Select your new profile picture</p>

									<label class="btn btn-secondary">
									    <span id="browse">Browse </span><input id="file" name="file" data-max-size="4000" accept="image/*" value="{{ old('file') }}" type="file" style="display: none;">
									</label>

								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary" name="submit">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="row margin-bottom-20">
				<img src="{{ asset($subject->getPicture()) }}" class="img-circle profile-picture-large center-block touchable" data-toggle="modal" data-target="#modal-upload" alt="" >
			</div>

			<hr>

			@if (Session::has('picture'))
				<div class="alert alert-success" role="alert">
					{{ Session::get('picture') }}
				</div>
			@endif
			@if ($errors->has('file'))
			<div class="alert alert-warning" role="alert">
				{{ $errors->first('file') }}
			</div>
			@endif

			<button class="btn btn-primary-outline center-block" type="button" data-toggle="modal" data-target="#modal-upload">Change</button>
		</div>
	</div>
</div>
