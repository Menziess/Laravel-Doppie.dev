<div id="delete" class="card card-block">
	<div class="row row-centered">
		<h4 class="card-title">Account</h4>
		<div class="col-md-6 col-md-offset-3">

			<p>All your data will be lost forever.</p>

			<div id="modal-delete" class="modal fade">
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
							<form id="form" class="form-horizontal" role="form" method="POST" action="{{ url('/user/delete/' . Auth::user()->getKey()) }}">
							{!! csrf_field() !!}
							{{ method_field('DELETE') }}
							<button type="button" class="btn btn-secondary-outline" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger">Delete</button>
							</form>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<hr>

			<button class="btn btn-danger center-block" type="submit" data-toggle="modal" data-target="#modal-delete">Delete</button>
		</div>
	</div>
</div>
