@extends('layouts.app')

@section('content')

@if(isset($users))
<div id="users" class="card">
	<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
	<div class="card-block">
		<h4 class="card-title">Users</h4>
		@if($users->count() > 0)

		<table class="table table-hover table-large text-small text-xs-left">
			<thead>
				<tr>
					<th>#</th>
					<th>Picture</th>
					<th>Name</th>
					<th class="hidden-xs-down">Email</th>
					<th class="hidden-xs-down">Creation Date</th>
				</tr>
			</thead>
		<tbody>
		@foreach($users as $user)
			<tr class="clickable-row" data-href="{{ url(Auth::user()->is_admin ? 'admin/user-settings/' . $user->id : $user->getProfileUrl()) }}">
				<td>{{ $user->id }}</td>
				<td><img src="{{ asset($user->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" ></td>
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
				<td class="hidden-xs-down">{{ $user->email }}</td>
				<td class="hidden-xs-down">{{ $user->created_at }}</td>
			</tr>
		@endforeach
		</tbody>
		</table>

		{!! $users !!}

		@if (Session::has('users'))
			<div class="alert alert-success" role="alert">
				{{ Session::get('users') }}
			</div>
		@endif

		@else
		No users found...
		@endif

	</div>
</div>
@endif


@if(isset($projects))
<div id="projects" class="card">
	<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
	<div class="card-block">
		<h4 class="card-title">Projects</h4>
		@if($projects->count() > 0)

		<table class="table table-hover table-large text-small text-xs-left">
			<thead>
				<tr>
					<th>#</th>
					<th>Picture</th>
					<th>Name</th>
					<th>Owner name</th>
					<th class="hidden-xs-down">Creation Date</th>
				</tr>
			</thead>
		<tbody>
		@foreach($projects as $project)
			<tr class="clickable-row" data-href="{{ url(Auth::user()->is_admin ? 'admin/project-settings/' . $project->id : $project->getProfileUrl()) }}">
				<td>{{ $project->id }}</td>
				<td><img src="{{ asset($project->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" ></td>
				<td>
					{{ $project->getName() }}
					@if(Auth::user()->is_admin)
					<br>
					{!! $project->is_active
						? '<span class="label label-pill label-success">active</span>'
						: '<span class="label label-pill label-warning">inactive</span>' !!}
					@endif
				</td>
				<td>{{ $project->getOwnerName() }}</td>
				<td class="hidden-xs-down">{{ $project->created_at }}</td>
			</tr>
		@endforeach
		</tbody>
		</table>

		{!! $projects !!}

		@if (Session::has('project'))
			<div class="alert alert-success" role="alert">
				{{ Session::get('project') }}
			</div>
		@endif

		@else
		No projects found...
		@endif

	</div>
</div>
@endif

@if(isset($organizations))
<div id="organizations" class="card">
	<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
	<div class="card-block">
		<h4 class="card-title">Organizations</h4>
		@if($organizations->count() > 0)

		<table class="table table-hover table-large text-small text-xs-left">
			<thead>
				<tr>
					<th>#</th>
					<th>Picture</th>
					<th>Name</th>
					<th>Owner name</th>
					<th class="hidden-xs-down">Creation Date</th>
				</tr>
			</thead>
		<tbody>
		@foreach($organizations as $organization)
			<tr class="clickable-row" data-href="{{ url(Auth::user()->is_admin ? 'admin/organization-settings/' . $organization->id : $organization->getProfileUrl()) }}">
				<td>{{ $organization->id }}</td>
				<td><img src="{{ asset($organization->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" ></td>
				<td>
					{{ $organization->getName() }}
					@if(Auth::user()->is_admin)
					<br>
					{!! $organization->is_active
						? '<span class="label label-pill label-success">active</span>'
						: '<span class="label label-pill label-warning">inactive</span>' !!}
					@endif
				</td>
				<td>{{ $organization->getOwnerName() }}</td>
				<td class="hidden-xs-down">{{ $organization->created_at }}</td>
			</tr>
		@endforeach
		</tbody>
		</table>

		{!! $organizations !!}

		@if (Session::has('organizations'))
			<div class="alert alert-success" role="alert">
				{{ Session::get('organizations') }}
			</div>
		@endif

		@else
		No organizations found...
		@endif

	</div>
</div>
@endif

@endsection


@push('scripts')
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});
</script>
@endpush
