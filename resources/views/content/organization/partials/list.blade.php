@if($organizations)
<div id="organizations" class="card">
	<div class="card-block">
		<h4 class="card-title">Organizations</h4>
		@if($organizations->count() > 0)

		<table class="table table-hover table-large text-small text-xs-left">
			<thead>
				<tr>
					<th>#</th>
					<th>Picture</th>
					<th>Name</th>
					<th class="hidden-xs-down">Owner name</th>
					<th class="hidden-xs-down">Creation Date</th>
				</tr>
			</thead>
		<tbody>
		@foreach($organizations->take(5) as $organization)
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
				<td class="hidden-xs-down">{{ $organization->getOwnerName() }}</td>
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
