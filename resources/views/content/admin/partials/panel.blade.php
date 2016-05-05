<div id="permissions" class="card card-block card-inverse" style="background-color: #333; border-color: #333;">

	<h4 class="card-title">Permissions</h4>
	<p class="card-text">
		User #{{ $user->id }} is {!! $user->is_admin ? '<span class="text-primary">admin</span>,' : '' !!} {!! $user->is_active
		? '<span class="text-success">active</span> and is able to login.'
		: '<span class="text-warning">inactive</span> and is unable to login. This content of this user is not vsible for other users.' !!}
	</p>

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
						Deleting this account will also remove all associated private data, are you sure?
					</p>
				</div>
				<div class="modal-footer">
					<form id="form" class="form-horizontal" role="form" method="POST" action="{{ url('/user/delete/' . $user->getKey()) }}">
					{!! csrf_field() !!}
					{{ method_field('DELETE') }}
					<button type="button" class="btn btn-secondary-outline" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete</button>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="btn-group btn-group-justified">
	<a href="{{ url('/admin/activate/' . $user->getKey()) }}" class="btn btn-success-outline" role="button">Activate</a>
	<a href="{{ url('/admin/deactivate/' . $user->getKey()) }}" class="btn btn-warning-outline" role="button">Deactivate</a>
	</div>
	<div class="padding-top">
	<a href="{{ url('/admin/toggleadmin/' . $user->getKey()) }}" class="btn btn-primary{{ $user->is_admin ? '' : '-outline' }}" role="button">Admin: {{ $user->is_admin ? 'true' : 'false' }}</a>
	</div>
</div>

<div id="account" class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
	<h4 class="card-title">Account</h4>
	<p class="card-text">Deleting User #{{ $user->id }} will also remove all associated private data.</p>
	<a data-toggle="modal" data-target="#modal-delete" href="#" class="btn btn-danger">Delete</a>
</div>
