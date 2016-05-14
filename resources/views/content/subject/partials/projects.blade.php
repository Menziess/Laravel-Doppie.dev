@if($subject->projects)
<div id="projects" class="card">
	<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
	<div class="card-block">
		<h4 class="card-title">Projects</h4>
		@if($subject->projects->count() > 0)

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
		@foreach($subject->projects->take(5) as $project)
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

		@else
		No projects found...
		@endif

	</div>
</div>
@endif
