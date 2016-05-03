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
							<td><img src="{{ asset($user->getPicture()) }}" class="img-circle width-100 profile-picture-small" style="width: 50px;" alt="" ></td>
							<td>
								{{ $user->getName() }}<br>
								{!! $user->is_active
									? '<span class="label label-pill label-success">active</span>'
									: '<span class="label label-pill label-warning">inactive</span>' !!}
								{!! $user->is_admin
									? '<span class="label label-pill label-primary">admin</span>'
									: '' !!}
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
