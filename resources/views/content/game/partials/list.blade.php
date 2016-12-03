@if(isset($games))
<div id="games" class="card shadow">
	<div class="card-block">
		<h4 class="card-title">{{ isset($title) ? ucfirst($title) : 'Games' }}</h4>
		@if(Auth::user()->is_admin)
			<a class="btn btn-primary-outline" href="{{ url('admin/users') }}">List of users</a>
		@endif
		@if($games->count() > 0)
	</div>

	<table class="table table-hover table-striped table-large text-small text-xs-left">
		<thead>
			<tr>
				<th>#</th>
				<th>Type</th>
				<th>Options</th>
				<th>Status</th>
				<th class="hidden-xs-down">Users</th>
			</tr>
		</thead>
	<tbody>
	@foreach($games as $game)
		<tr>
			<td><h3>{{ $game->id }}</h3></td>
			<td>
				<img src="{{ asset($game->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" >
			</td>
			<td>
				<button style="display: inline-block;" class="btn btn-danger-outline center-block" type="button" data-toggle="modal" data-target="#modal-delete">Stop</button>
			</td>
			<td>
				{{ $game->created_at ? $game->created_at->toFormattedDateString() : null }} {{ $game->finished_at ? ' - ' . $game->finished_at->toFormattedDateString() : null }}
				<br/>
				{!! $game->deleted_at
					? '<span class="label label-pill label-warning">inactive</span>'
					: '<span class="label label-pill label-success">active</span>' !!}
			</td>
			<td class="hidden-xs-down">{{ $game->users->count() }}</td>
		</tr>
	@endforeach
	</tbody>
	</table>

	@else
	No games found...
	@endif

</div>
@endif

<div id="bottom" class="row">
	<div id="modal-delete" class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
					<h4 class="modal-title">Delete {{ class_basename($game) }}</h4>
				</div>
				<div class="modal-body">
					<p>
						Beware <strong>{{ Auth::user()->first_name }}</strong>,<br/>
						your action will be registered and charged against you in case of game manipulation.
						@if($game->started_at->addMinutes(80) > Carbon\Carbon::now())
						<br/><br/>
						Time untill delete button will be publicly available in:<br/>
						<b>{{ $game->started_at->addMinutes(80)->diffInMinutes(Carbon\Carbon::now()) }}</b> minutes
						@endif
					</p>
				</div>
				<div class="modal-footer">
					@if(Auth::user() == $game->user || Auth::user()->is_admin || $game->started_at->addMinutes(80) < Carbon\Carbon::now())
					<form class="form-horizontal" method="POST" action="{{ url('game/delete-game') }}">
						{!! csrf_field() !!}
						{{ method_field('DELETE') }}
						<button class="btn btn-danger" type="submit">Delete</button>
					</form>
					@else
						<button class="btn btn-danger disabled">Delete</button>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<script>
</script>
