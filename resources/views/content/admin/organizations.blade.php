@extends('layouts.app')

@section('content')

<div class="col fluid">

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
			<tr class="clickable-row" data-href="{{ url('/admin/organization/' . $organization->id) }}">
				<td>{{ $organization->id }}</td>
				<td><img src="{{ asset($organization->getPicture()) }}" class="img-circle profile-picture-small" style="width: 50px;" alt="" ></td>
				<td>
					{{ $organization->getName() }}<br>
					{!! $organization->is_active
						? '<span class="label label-pill label-success">active</span>'
						: '<span class="label label-pill label-warning">inactive</span>' !!}
				</td>
				<td>{{ $organization->getOwnerName() }}</td>
				<td class="hidden-xs-down">{{ $organization->created_at }}</td>
			</tr>
		@endforeach
		</tbody>
		</table>

		{!! $organizations !!}
	@else
		No organizations... Sorry!
	@endif

</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});
</script>

@endsection
