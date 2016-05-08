@extends('layouts.app')

@section('content')

<div class="col fluid">

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
			<tr class="clickable-row" data-href="{{ url('/admin/project/' . $project->id) }}">
				<td>{{ $project->id }}</td>
				<td><img src="{{ asset($project->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" ></td>
				<td>
					{{ $project->getName() }}<br>
					{!! $project->is_active && Auth::user()->is_admin
						? '<span class="label label-pill label-success">active</span>'
						: '<span class="label label-pill label-warning">inactive</span>' !!}
				</td>
				<td>{{ $project->getOwnerName() }}</td>
				<td class="hidden-xs-down">{{ $project->created_at }}</td>
			</tr>
		@endforeach
		</tbody>
		</table>

		{!! $projects !!}
	@else
		No projects... Sorry!
	@endif

</div>

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
