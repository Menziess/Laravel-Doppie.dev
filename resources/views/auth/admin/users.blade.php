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
								<th>Email</th>
								<th class="hidden-xs-down">Creation Date</th>
							</tr>
						</thead>
					<tbody>
					@foreach($users as $user)
						@if($user->trashed())
						<tr class="clickable-row bg-warning" data-href="{{ url('/admin/show/' . $user->id) }}">
						@else
						<tr class="clickable-row" data-href="{{ url('/admin/show/' . $user->id) }}">
						@endif
							<td>{{ $user->id }}</td>
							<td><img src="{{ asset('images/profile/' . $user->id) }}" class="img-circle width-100 profile-picture-small" style="width: 50px;" alt="" ></td>
							<td>{{ $user->first_name }} {{ $user->last_name }}</td>
							<td>{{ $user->email }}</td>
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
