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
								<th>Name</th>
								<th>Email</th>
								<th>Creation Date</th>
							</tr>
						</thead>
					<tbody>
					@foreach($users as $user)
						<tr class="clickable-row" data-href="{{ url('/user/show/' . $user->id) }}">
							<td>{{ $user->id }}</td>
							<td>{{ $user->first_name }} {{ $user->last_name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->created_at }}</td>
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
