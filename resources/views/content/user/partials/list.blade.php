@if(isset($users))
<div id="users" class="card shadow">
	<div class="card-block">
		<h4 class="card-title">{{ isset($title) ? ucfirst($title) : 'Users' }}</h4>
		@if(Auth::user()->is_admin)
			<a class="btn btn-primary-outline" href="{{ url('admin/games') }}">List of games</a>
		@endif
		@if($users->count() > 0)
	</div>

	<table class="table table-hover table-striped table-large text-small text-xs-left">
		<thead>
			<tr>
				<th>Level</th>
				<th>Picture</th>
				<th>Name</th>
				<th class="hidden-xs-down">Email</th>
				<th class="hidden-xs-down">Creation Date</th>
			</tr>
		</thead>
	<tbody>
	@foreach($users as $user)
		<tr class="clickable-row touchable" data-href="{{ url($user->getProfileUrl()) }}">
			<td><h3>{{ $user->getLevel() }}</h3></td>
			<td>
				<a {{ Auth::user()->is_admin ? 'href=' . url('admin/user/' . $user->id) : '' }}>
					<img src="{{ asset($user->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" >
				</a>
			</td>
			<td>
				{{ $user->getName() }}
				@if(Auth::user()->is_admin)
				<br>
				{!! $user->is_active
					? '<span class="label label-pill label-success">active</span>'
					: '<span class="label label-pill label-warning">inactive</span>' !!}
				{!! $user->is_admin
					? '<span class="label label-pill label-primary">admin</span>'
					: '' !!}
				@endif
			</td>
			<td class="hidden-xs-down">
				{{ $user->email }}
			</td>
			<td class="hidden-xs-down">{{ $user->created_at ? $user->created_at->toFormattedDateString() : null }}</td>
		</tr>
		<tr>
			<td>
				<progress
					style="position: absolute; margin: -1em -1em;"
					class="progress progress-primary" value="{{ $user->getLevelObtainedXp() }}" min="{{ $user->getLevelRequiredXp($subject->getLevel() - 1) }}" max="{{ $subject->getLevelRequiredXp($subject->getLevel()) }}">
				</progress>
			</td>
		</tr>
	@endforeach
	</tbody>
	</table>

	@else
	No users found...
	@endif

</div>
@endif
