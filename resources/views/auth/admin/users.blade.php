@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row row-centered">
		<div class="col fluid">
			<div class="panel panel-default">

				@if(isset($users))
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
						<tr class="clickable-row" data-href="{{ url('/admin/show/' . $user->id) }}">
							<td>{{ $user->id }}</td>
							@if($user->profile->resource)
							<td><img src="{{ asset('images/profile/' . $user->id) }}" class="img-circle width-100 profile-picture-small" style="width: 50px;" alt="" ></td>
							@else
							<td><img src="{{ asset('img/placeholder.jpg') }}" class="img-circle width-100 profile-picture-small" style="width: 50px;" alt="" ></td>
							@endif
							<td>{{ $user->first_name }} {{ $user->last_name }}<br>
								@if($user->is_active)
								<span class="label label-pill label-success">active</span>
								@else
								<span class="label label-pill label-warning">inactive</span>
								@endif
							</td>
							<td class="hidden-xs-down">{{ $user->email }}</td>
							<td class="hidden-xs-down">{{ $user->created_at }}</td>
						</tr>
					@endforeach
					</tbody>
					</table>

					{!! $users !!}
				@else
					No users... Sorry!
				@endif

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});
</script>
@endsection
