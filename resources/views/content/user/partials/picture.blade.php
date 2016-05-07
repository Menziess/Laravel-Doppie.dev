<div id="picture" class="card card-block">
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
				<img src="{{ asset($user->getPicture()) }}" class=" img-circle profile-picture-small center-block" data-toggle="modal" data-target="#modal-upload" alt="" >
			</div>
			<hr>
			<button class="btn btn-primary-outline center-block" type="button" data-toggle="modal" data-target="#modal-upload">Upload</button>
		</div>
	</div>
</div>