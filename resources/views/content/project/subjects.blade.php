@extends('layouts.app')

@section('content')

	@if($subject->users)
	<div class="card">
		<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
		<div class="card-block">
			<h4 class="card-title">Users</h4>
			@if($subject->users->count() > 0)

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
			@foreach($subject->users->take(5) as $user)
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

			@else
			No users found...
			@endif

		</div>
	</div>
	@endif

	@if($subject->organizations)
	<div id="organizations" class="card">
		<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
		<div class="card-block">
			<h4 class="card-title">Organizations</h4>
			@if($subject->organizations->count() > 0)

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
			@foreach($subject->organizations->take(5) as $organization)
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

			@else
			No organizations found...
			@endif

		</div>
	</div>
	@endif

@endsection
