@if(isset($games))
<div id="games" class="card shadow">
	<div class="card-block">
		<h4 class="card-title">{{ isset($title) ? ucfirst($title) : 'Games' }}</h4>
		@if(Auth::user()->is_admin)
			<a class="btn btn-secondary" href="{{ url('admin/users') }}">List of users</a>
		@endif
		@if($games->count() > 0)
	</div>

	<table class="table table-hover table-striped table-large text-small text-xs-left">
		<thead>
			<tr>
				<th>#</th>
				<th>Type</th>
				<th>Status</th>
				<th class="hidden-xs-down">Users</th>
			</tr>
		</thead>
	<tbody>
	@foreach($games as $game)
		<tr class="clickable-row touchable" data-href="{{ url($game->getUrl()) }}">
			<td><h3>{{ $game->id }}</h3></td>
			<td>
				<img src="{{ asset($game->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="">
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
