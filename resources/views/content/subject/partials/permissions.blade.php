<div id="permissions" class="card card-block card-inverse" style="background-color: #333; border-color: #333;">

	<h4 class="card-title">Permissions</h4>
	<p class="card-text">
		{{ ucwords($subject->getModel()) }} #{{ $subject->id }} is {!! $subject->is_active
		? '<span class="text-success">active</span> and can be seen by other users.'
		: '<span class="text-warning">inactive</span> and is hidden for other users.' !!}
	</p>

	<div id="modal-delete" class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
					<h4 class="modal-title">Delete {{ $subject->getModel() }}</h4>
				</div>
				<div class="modal-body">
					<p>
						Deleting this {{ $subject->getModel() }} will also remove all associated private data, are you sure?
					</p>
				</div>
				<div class="modal-footer">
					<form id="form" class="form-horizontal" role="form" method="POST" action="{{ url('/' . $subject->getModel() . '/delete/' . $subject->getKey()) }}">
					{!! csrf_field() !!}
					{{ method_field('DELETE') }}
					<button type="button" class="btn btn-secondary-outline" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger">Delete</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="btn-group btn-group-justified">
	<form id="form-profile" class="form-horizontal" method="POST" action="{{ url('/admin/activate-' . $subject->getModel() . '/' . $subject->getKey()) }}">
		{!! csrf_field() !!}
		{{ method_field('PUT') }}
		<button class="btn btn-success-outline" type="submit">Activate</a>
	</form>
	</div>

	<div class="btn-group btn-group-justified">
	<form id="form-profile" class="form-horizontal" method="POST" action="{{ url('/admin/deactivate-' . $subject->getModel() . '/' . $subject->getKey()) }}">
		{!! csrf_field() !!}
		{{ method_field('PUT') }}
		<button class="btn btn-warning-outline" type="submit">Deactivate</a>
	</form>
	</div>
</div>

<div id="delete" class="card card-block card-inverse" style="background-color: #333; border-color: #333;">
	<h4 class="card-title">{{ ucwords($subject->getModel()) }}</h4>

	<p class="card-text">Deleting {{ $subject->getModel() }}  #{{ $subject->id }} will also remove all associated private data.</p>

	@if ($errors->has($subject->getModel()))
		<div class="alert alert-warning" role="alert">
			{{ $errors->first($subject->getModel()) }}
		</div>
	@endif

	<div>
	<a data-toggle="modal" data-target="#modal-delete" href="#" class="btn btn-danger">Delete</a>
	</div>
</div>
